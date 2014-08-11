$(document).ready(function(){
var seoHrefs = {'f34bb62f734d1cecaa4de6a8b8efab52':'aHR0cDovL3d3dy5zZW93aW5kLnJ1L2tvbmt1cnN5LWktYWtjaWkva29ua3Vycy10b3Ata29tbWVudGF0b3Jvdi8='};
$('[hashString]').each(function(){
var key = $(this).attr('hashString');
if($(this).attr('hashType') == 'href' && seoHrefs.hasOwnProperty(key)){
$(this).attr('href', Base64.decode(seoHrefs[key]));
}
});
});