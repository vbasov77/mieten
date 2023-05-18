<label for="service"><b>Сервис:</b></label><br>

<label><b>Техника:</b></label><br>
<label class="checkbox-btn2">
    <input type="checkbox" name="service[]"
           @php
               if (in_array("кондиционер", $service)) {
                   echo 'checked';

               }@endphp
           value="кондиционер">
    <span>Кондиционер</span>
</label>

<label class="checkbox-btn2">
    <input type="checkbox" name="service[]"
           @php
               if (in_array("холодильник", $service)) {
                   echo 'checked';

               }@endphp
           value="холодильник">
    <span>Холодильник</span>
</label>

<label class="checkbox-btn2">
    <input type="checkbox" name="service[]"
           @php
               if (in_array("плита", $service)) {
                   echo 'checked';

               }@endphp
           value="плита">
    <span>Плита</span>
</label>

<label class="checkbox-btn2">
    <input type="checkbox" name="service[]"
           @php
               if (in_array("микроволновка", $service)) {
                   echo 'checked';

               }@endphp
           value="микроволновка">
    <span>Микроволновка</span>
</label>

<label class="checkbox-btn2">
    <input type="checkbox" name="service[]"
           @php
               if (in_array("стиральная машина", $service)) {
                   echo 'checked';

               }@endphp
           value="стиральная машина">
    <span>Стиральная машина</span>
</label>

<label class="checkbox-btn2">
    <input type="checkbox" name="service[]"
           @php
               if (in_array("посудомоецная машина", $service)) {
                   echo 'checked';

               }@endphp
           value="посудомоецная машина">
    <span>Посудомоецная машина</span>
</label>

<label class="checkbox-btn2">
    <input type="checkbox" name="service[]"
           @php
               if (in_array("водонагреватель", $service)) {
                   echo 'checked';

               }@endphp
           value="водонагреватель">
    <span>Водонагреватель</span>
</label>

<label class="checkbox-btn2">
    <input type="checkbox" name="service[]"
           @php
               if (in_array("телевизор", $service)) {
                   echo 'checked';

               }@endphp
           value="телевизор">
    <span>Телевизор</span>
</label>

<label class="checkbox-btn2">
    <input type="checkbox" name="service[]"
           @php
               if (in_array("фен", $service)) {
                   echo 'checked';

               }@endphp
           value="фен">
    <span>Фен</span>
</label>

<label class="checkbox-btn2">
    <input type="checkbox" name="service[]"
           @php
               if (in_array("утюг", $service)) {
                   echo 'checked';

               }@endphp
           value="утюг">
    <span>Утюг</span>
</label>
<br>
<br>
<label><b>Интернет и ТВ:</b></label><br>

<label class="checkbox-btn2">
    <input type="checkbox" name="service[]"
           @php
               if (in_array("vi-fi", $service)) {
                   echo 'checked';

               }@endphp
           value="vi-fi">
    <span>Vi-Fi</span>
</label>
<label class="checkbox-btn2">
    <input type="checkbox" name="service[]"
           @php
               if (in_array("телевидение", $service)) {
                   echo 'checked';

               }@endphp
           value="телевидение">
    <span>Телевидение</span>
</label>
<br>
<br>
<label><b>Комфорт:</b></label><br>
<label class="checkbox-btn2">
    <input type="checkbox" name="service[]"
           @php
               if (in_array("постельное бельё", $service)) {
                   echo 'checked';

               }@endphp
           value="постельное бельё">
    <span>Постельное бельё</span>
</label>

<label class="checkbox-btn2">
    <input type="checkbox" name="service[]"
           @php
               if (in_array("полотенца", $service)) {
                   echo 'checked';

               }@endphp
           value="полотенца">
    <span>Полотенца</span>
</label>

<label class="checkbox-btn2">
    <input type="checkbox" name="service[]"
           @php
               if (in_array("средства гигиены", $service)) {
                   echo 'checked';

               }@endphp
           value="средства гигиены">
    <span>Средства гигиены</span>
</label>