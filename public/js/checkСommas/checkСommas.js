function checkСommas(input) {
    ch = input.value.replace(/[^\d.]/g, ''); //разрешаем вводить только числа и запятую
    pos = ch.indexOf('.'); // проверяем, есть ли в строке запятая
    const numberOfСommas = input.value.replace(/[^.]/g,"").length;
    console.log(numberOfСommas);
    if(pos != -1){ // если запятая есть
        if((ch.length - pos > 3 || numberOfСommas > 1) ){ // проверяем, сколько знаков после запятой, если больше 1го то
            ch = ch.slice(0, -1); // удаляем лишнее
        }
    }
    input.value = ch; // приписываем в инпут новое значение
};