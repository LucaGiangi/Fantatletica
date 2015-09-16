<script type="text/javascript">
function chiamaAjax()
{
var xmlhttp;
if (window.XMLHttpRequest)
   {
   // codice valido per IE7 e succ., Firefox, Chrome, Opera, Safari
   xmlhttp=new XMLHttpRequest();
   }
else if (window.ActiveXObject)
   {
   // codice valido per IE6 e IE5
   xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
   }
else
   {
   alert("Il browser non supporta XMLHTTP");
   }
xmlhttp.onreadystatechange=function()
{
if(xmlhttp.readyState==4)
   {
   document.getElementById('articoli').innerHTML=xmlhttp.responseText;
   }
}
xmlhttp.open("GET","stampa_articoli.php",true);
xmlhttp.send(null);
}

chiamaAjax();
</script>
