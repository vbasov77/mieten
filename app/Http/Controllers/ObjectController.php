<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Coordinates;
use App\Models\Country;
use App\Models\Detail;
use App\Models\Image;
use App\Models\Locality;
use App\Models\Obj;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;


class ObjectController extends Controller
{

    public function view(Request $request)
    {
        $obj = Obj::leftJoin('coordinates', 'objects.id', '=', 'coordinates.obj_id')
            ->leftJoin('addresses', 'objects.id', '=', 'addresses.obj_id')
            ->leftJoin('video', 'objects.id', '=', 'video.obj_id')
            ->leftJoin('details', 'objects.id', '=', 'details.obj_id')
            ->where('objects.id', $request->id)
            ->get(['objects.*',
                'details.title', 'details.price', 'details.capacity', 'details.count_rooms',
                'details.service', 'details.text_obj',
                'coordinates.coordinates', 'addresses.address', 'video.path']);
        $images = Image::where('obj_id', $request->id)->pluck('path');
        if (isset($obj)) {

            return view('objects.view', ['data' => $obj[0], 'images' => $images]);
        }
        $message = "Скорее всего объект был удалён...";

        return view('sorry.sorry', ['message' => $message]);
    }

    public function addAddress(Request $request)
    {
        if ($request->isMethod('get')) {
            // этот код выполнится, если используется метод GET
            return view('objects.add_address');
        }
        if ($request->isMethod('post')) {
            // этот код выполнится, если используется метод POST
            $request->validate([
                'address' => 'required|max:255',
            ]);
            $id = Obj::insertGetId([
                'user_id' => Auth::user()->id,
                'address' => $request->address,
            ]);
            self::getAddress($request->address, $id);
            return redirect()->action('ObjectController@edit', ['id' => $id]);

        }
    }


    public function edit(Request $request)
    {
        if ($request->isMethod('get')) {
            // этот код выполнится, если используется метод GET
            $obj = Obj::
            leftJoin('addresses', 'objects.id', '=', 'addresses.obj_id')
                ->leftJoin('video', 'objects.id', '=', 'video.obj_id')
                ->where('objects.id', $request->id)
                ->get(['objects.*', 'addresses.address', 'video.path']);
            $images = Image::where('obj_id', $request->id)->pluck('path');
            $service = explode(',', $obj[0]->service);
            if (isset($obj)) {
                return view('objects.edit', ['obj' => $obj[0], 'images' => $images, 'service' => $service]);
            }
            $message = "Скорее всего объект был удалён...";
            return view('sorry.sorry', ['message' => $message]);

        }
        if ($request->isMethod('post')) {
            // этот код выполнится, если используется метод POST
            if (!empty($request->id)) {
                $service = null;
                if (isset($request->service)) {
                    $service = (string)implode(',', $request->service);
                }
                $obj = Detail::where('obj_id', $request->id)->first();
                if (isset($obj)) {
                    Detail::where('obj_id', $request->id)->update([
                        'price' => $request->price,
                        'title' => $request->title,
                        'text_obj' => $request->text_room,
                        'count_rooms' => $request->count_rooms,
                        'capacity' => $request->capacity,
                        'service' => $service,
                    ]);
                    if ($_POST['video'] !== '') {
                        $video = Video::where('obj_id', $request->id)->get();
                        if (!empty(count($video))) {
                            Video::where('obj_id', $request->id)->update([
                                'path' => $request->video
                            ]);
                        } else {
                            Video::insert([
                                'obj_id' => $request->id,
                                'path' => $request->video
                            ]);
                        }
                    }
                    $res = ['answer' => 'ok'];
                } else {
                    Detail::insert([
                        'obj_id' => $request->id,
                        'price' => $request->price,
                        'title' => $request->title,
                        'text_obj' => $request->text_room,
                        'count_rooms' => $request->count_rooms,
                        'capacity' => $request->capacity,
                        'service' => $service,
                    ]);
                    $res = ['answer' => 'ok'];
                }
            } else {
                $res = ['answer' => 'error'];
            }
            exit(json_encode($res));
        }
    }

    public function delete(Request $request)
    {
        // Адрес, координаты, фото, объект, видео
        Address::where('obj_id', $request->id)->delete();
        Coordinates::where('obj_id', $request->id)->delete();
        Obj::where('id', $request->id)->delete();
        Video::where('obj_id', $request->id)->delete();
        $img = Image::where('obj_id', $request->id)->pluck('path');
        for ($i = 0; $i < count($img); $i++) {
            File::delete(public_path('images/' . $img[$i]));// Удалили файл
        }
        Image::where('obj_id', $request->id)->delete();
        Detail::where('obj_id', $request->id)->delete();

    }

    public function updateLocation(Request $request)
    {
        $request->session()->forget('locality');
        $request->session()->save();
        return redirect()->action('FrontController@front');
    }

    public static function getAddress(string $address, int $objId)
    {
        // Получение координат и подробного адреса - Страна, Область, город, улица, дом...

        $key = "c5583e4f-c62e-418f-bb87-3c814516c530";
        $ch = curl_init('https://geocode-maps.yandex.ru/1.x/?apikey=' . $key . '&format=json&geocode=' . urlencode($address));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $res = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($res, true);
        $coordinatesStr = $response['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos'];
        $coordinatesArr = explode(' ', $coordinatesStr);
        $coordinates = $coordinatesArr[1] . ', ' . $coordinatesArr[0];

        Coordinates::insert(['obj_id' => $objId, 'coordinates' => $coordinates]);

        $object = $response['response']['GeoObjectCollection']
        ['featureMember'][0]['GeoObject']['metaDataProperty']
        ['GeocoderMetaData']['Address']['Components'];


        $countryId = self::getCountryId($object);
        $localityId = self::getLocalityId($object, $countryId);
        $address = [];
        $address[] = self::getAddressName($object, "street");
        $address[] = self::getAddressName($object, "house");
        $address = implode(',', $address);

        Address::insert(['obj_id' => $objId, 'country' => $countryId, 'locality' => $localityId, 'address' => $address]);

    }

    public static function getLocalityId(array $object, int $country_id)
    {
        for ($i = 0; $i < count($object); $i++) {
            if ($object[$i]['kind'] === "locality") {
                $data = $object[$i]['name'];
                $check = Locality::where("locality", $data)->first();
                if (isset($check)) {
                    $id = Locality::where("locality", $data)
                        ->value('id');
                    return $id;
                } else {
                    $id = Locality::insertGetId([
                        'locality' => $data,
                        'country_id' => $country_id,
                    ]);
                    return $id;
                }
            }
        }
    }

    public static function getCountryId(array $object)
    {
        for ($i = 0; $i < count($object); $i++) {
            if ($object[$i]['kind'] === "country") {
                $data = $object[$i]['name'];
                $check = Country::where("country", $data)->first();
                if (isset($check)) {
                    $id = Country::where("country", $data)
                        ->value('id');
                    return $id;
                } else {
                    $id = Country::insertGetId([
                        "country" => $data,
                    ]);
                    return $id;
                }
            }
        }
    }

    public static function getAddressName(array $object, string $component)
    {
        for ($i = 0; $i < count($object); $i++) {
            if ($object[$i]['kind'] === $component) {
                return $object[$i]['name'];
            }
        }
    }

    public static function insertImages(int $obj_id, string $images)
    {
        $images = explode(',', $images);
        $data = "";
        for ($i = 0; $i < count($images); $i++) {
            $more = "(" . $obj_id . ", '" . $images[$i] . "'),";
            $data = $data . $more;
        }
        $data = substr($data, 0, -1);
        DB::insert('insert into images (obj_id, path) values ' . $data);
    }


}
