define([], function () {
    var mageJsComponent = function(config, node)
    {
        alert("Your Js module is working");
        console.log(config);
        console.log(node);
    };

    return mageJsComponent;
});
