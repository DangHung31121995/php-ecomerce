$(function() {
    $(".clickedit").editable("index.php?module=statistics&view=business&raw=1&task=save_business_results", { 
        indicator : "<img src='/images/process.gif'>",
        tooltip   : "Click để nhập...",
        type: 'text'
    });
});