window.changeCities = function (source, target, route) {
    var selectedProvince = $(source).val();
    var url = route + '?province=' + selectedProvince;
    $(target).empty();
    
    var newOption;
    $.get(url, function (data) {
        data.cities.forEach(function (val) {
            newOption = new Option(val.name, val.id, false, false);
            $(target).append(newOption);
        })
    });

    // var newOption;
    // data.category.forEach(function (item) {
    //     newOption = new Option(item.name, item.id, false, false);
    //     categoryElement.append(newOption);
    // })

};