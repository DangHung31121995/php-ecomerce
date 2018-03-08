$(document).ready(function(){
    $left = $('#navigation > ul > li.selected').position().left;
    $('li.selected ul.selected li:first').css('margin-left', $left+'px');
});