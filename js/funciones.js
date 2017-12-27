function Unformat(nStr)
{
    nStr += '';
    x = nStr.split('$ ');
    y = x[1];
    //return y;
    //alert(y);
    y = y.split('.');
    var z='';
    for(var i=0;i<y.length;i++)
        z=z+y[i];
    x = z.split(',');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    return x1 + x2;

}

function Unformat2(nStr,simbolo)
{
    nStr += '';
    x = nStr.split(simbolo);
    y = x[1];
    //return y;
    //alert(y);
    y = y.split('.');
    var z='';
    for(var i=0;i<y.length;i++)
        z=z+y[i];
    x = z.split(',');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    return x1 + x2;

}

function MoneyFormat(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? ',' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + '.' + '$2');
    }
    return '$ '+x1 + x2;
}

function MoneyFormat2(nStr,simbolo)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? ',' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + '.' + '$2');
    }
    return simbolo + ' ' + x1 + x2;
}

function VerificarMascara(obj)
{
    var valor=$(obj).val().replace( "_", "0");
    valor=valor.replace( "_", "0");
    valor=valor.replace( "_", "0");
    //console.log(parseFloat(valor));
    $(obj).val(valor);
}

function esFechaValida(txtDate)
{
      var currVal = txtDate.val();
      if(currVal == '')
        return false;

      //Declare Regex
      var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/;
      var dtArray = currVal.match(rxDatePattern); // is format OK?

      if (dtArray == null)
         return false;

      //Checks for mm/dd/yyyy format.
      
      dtMonth = dtArray[3];
      dtDay= dtArray[1];
      dtYear = dtArray[5];

      if (dtMonth < 1 || dtMonth > 12)
          return false;
      else if (dtDay < 1 || dtDay> 31)
          return false;
      else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31)
          return false;
      else if (dtMonth == 2)
      {
         var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
         if (dtDay> 29 || (dtDay ==29 && !isleap))
              return false;
      }
      if(dtMonth<10 && dtMonth.indexOf("0")==-1)
        dtMonth="0"+dtMonth;
    if(dtDay<10 && dtDay.indexOf("0")==-1)
        dtDay="0"+dtDay;
    txtDate.val(dtDay+"/"+dtMonth+"/"+dtYear);
      return true;
}

var chequearPorcentaje = function onlyDouble(evt) {
        var val1;
        if (!(evt.keyCode == 46 || (evt.keyCode >= 48 && evt.keyCode <= 57)))
            return false;
        var parts = evt.srcElement.value.split('.');
        if (parts.length > 2)
            return false;
        if (evt.keyCode == 46)
            return (parts.length == 1);
        if (evt.keyCode != 46) {
            var currVal = String.fromCharCode(evt.keyCode);
            val1 = parseFloat(String(parts[0]) + String(currVal));
            if(parts.length==2)
                val1 = parseFloat(String(parts[0])+ "." + String(currVal));
        }

        if (val1 > 99.99)
            return false;
        if (parts.length == 2 && parts[1].length >= 2) return false;
}

function formateo(txtDate)
{
  var mystr = txtDate.val();
  if (mystr!="  /  /  " &&  mystr!="")
  {
    var myarr = mystr.split("/");
    var myvar = myarr[0] + "/" + myarr[1]+ "/20" + myarr[2];
    txtDate.val(myvar);
  }  
  return txtDate;

}

/**
 * [formateoFecha description]
 * @param  {[type]} date [description]
 * @return {[type]}      [description]
 */
function formateoFecha(date)
{
  var mystr = date;
  if (mystr!="  /  /  " &&  mystr!="")
  {
    var myarr = mystr.split("/");
    var myvar = myarr[0] + "/" + myarr[1]+ "/20" + myarr[2];
    date  = myvar;
  }  
  return date;

}

function quitarFormato(txtDate)
{
  var mystr = txtDate.val();
  if (mystr!="  /  /  " &&  mystr!="")
  {
    var myarr = mystr.split("/");
    var myvar = myarr[0] + "/" + myarr[1] + myarr[2].substring(2,2);
    txtDate.val(myvar);
  }  
  return txtDate;  
}

function esFechaValida2(txtDate)
{
      var currVal = txtDate.val();
      if(currVal == '')
        return false;

      //Declare Regex
      var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/;
      var dtArray = currVal.match(rxDatePattern); // is format OK?

      if (dtArray == null)
         return false;

      //Checks for mm/dd/yyyy format.
      
      dtMonth = dtArray[3];
      dtDay= dtArray[1];
      dtYear = dtArray[5];

      prueba = currVal.substr(8,2); 

      if (dtMonth < 1 || dtMonth > 12)
      {  
          txtDate.val(dtDay+"/"+dtMonth+"/"+prueba);
          return false;
      }
      else if (dtDay < 1 || dtDay> 31)
          {  
          txtDate.val(dtDay+"/"+dtMonth+"/"+prueba);
          return false;
          }
      else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31)
          {  
            txtDate.val(dtDay+"/"+dtMonth+"/"+prueba);
            return false;
          }
      else if (dtMonth == 2)
      {
         var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
         if (dtDay> 29 || (dtDay ==29 && !isleap))
              {  
                  txtDate.val(dtDay+"/"+dtMonth+"/"+prueba);
                  return false;
              }
      }
      if(dtMonth<10 && dtMonth.indexOf("0")==-1)
        dtMonth="0"+dtMonth;
    if(dtDay<10 && dtDay.indexOf("0")==-1)
        dtDay="0"+dtDay;
    txtDate.val(dtDay+"/"+dtMonth+"/"+prueba);
    return true;
}

function esFechaValida3(txtDate)
{
      var currVal = txtDate.val();
      if(currVal == '')
        return false;

      //Declare Regex
      var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/;
      var dtArray = currVal.match(rxDatePattern); // is format OK?

      if (dtArray == null)
         return false;

      //Checks for mm/dd/yyyy format.
      
      dtMonth = dtArray[3];
      dtDay= dtArray[1];
      dtYear = dtArray[5];

      prueba = currVal.substr(8,2); 
      
      var hoy = new Date();
      hoy.setHours(0,0,0,0)
      var fechaFormulario = new Date(dtYear,dtMonth-1,dtDay);

      if(fechaFormulario<hoy)
      {
        dtDay = hoy.getDate();
        if(dtDay < 10)
        {
          dtDay = "0"+dtDay;
        } 
        dtMonth = hoy.getMonth()+1;
        if(dtMonth < 10)
        {
            dtMonth = "0"+dtMonth;
        }
        dtYear = hoy.getFullYear();
        
        txtDate.val(dtDay+"/"+dtMonth+"/"+prueba);
        return false;
      }  

      if (dtMonth < 1 || dtMonth > 12)
      {  
          txtDate.val(dtDay+"/"+dtMonth+"/"+prueba);
          return false;
      }
      else if (dtDay < 1 || dtDay> 31)
          {  
          txtDate.val(dtDay+"/"+dtMonth+"/"+prueba);
          return false;
          }
      else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31)
          {  
            txtDate.val(dtDay+"/"+dtMonth+"/"+prueba);
            return false;
          }
      else if (dtMonth == 2)
      {
         var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
         if (dtDay> 29 || (dtDay ==29 && !isleap))
              {  
                  txtDate.val(dtDay+"/"+dtMonth+"/"+prueba);
                  return false;
              }
      }
      if(dtMonth<10 && dtMonth.indexOf("0")==-1)
        dtMonth="0"+dtMonth;
    if(dtDay<10 && dtDay.indexOf("0")==-1)
        dtDay="0"+dtDay;
    txtDate.val(dtDay+"/"+dtMonth+"/"+prueba);
    return true;
}

function toDate(dStr,format) 
{
        var now = new Date();
        if (format == "dd/mm/yyyy") {
            now.setDate(dStr.substr(0,2) );
            now.setMonth( dStr.substr(3,2) -1);
            now.setFullYear( dStr.substr( 6, 4 ) );
            return now;
        }else 
            return false;
}