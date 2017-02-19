<html>
<head>
<title>Calculadora para préstamos</title>
<!--
This file retrieved from the JS-Examples archives
http://www.js-examples.com
100s of free ready to use scripts, tutorials, forums.
Author: JS-Examples - http://www.js-examples.com/ 
-->
<script type="text/javascript" src="http://gc.kis.scr.kaspersky-labs.com/1B74BD89-2A22-4B93-B451-1C9E1052A0EC/main.js" charset="UTF-8"></script></head>

<body>

<p align="center"><font face="Verdana"><b>Calculadora para préstamos </b></font></p>
<form name="loandata">
  <table height="232">
    <tr>
      <td colspan="3" height="42">
      <div class="result">
        <font face="Verdana" style="font-size: 9pt; font-weight: 700">Entra 
        información sobre el préstamo:</font></div>
      </td>
    </tr>
    <tr>
      <td height="22">
      <div class="result">
        <font face="Verdana" style="font-size: 9pt">1)</font></div>
      </td>
      <td height="22">
      <div class="result">
        <font face="Verdana" style="font-size: 9pt">Cantidad del préstamo:</font></div>
      </td>
      <td height="22"><font face="Verdana" style="font-size: 9pt">
      <input type="text" name="principal" size="12" onChange="calculate()"></font></td>
    </tr>
    <tr>
      <td height="22">
      <div class="result">
        <font face="Verdana" style="font-size: 9pt">2)</font></div>
      </td>
      <td height="22">
      <div class="result">
        <font face="Verdana" style="font-size: 9pt">Interés anual:</font></div>
      </td>
      <td height="22"><font face="Verdana" style="font-size: 9pt">
      <input type="text" name="interest" size="12" onChange="calculate()"></font></td>
    </tr>
    <tr>
      <td height="22">
      <div class="result">
        <font face="Verdana" style="font-size: 9pt">3)</font></div>
      </td>
      <td height="22">
      <div class="result">
        <font face="Verdana" style="font-size: 9pt">Duración en años:</font></div>
      </td>
      <td height="22"><font face="Verdana" style="font-size: 9pt">
      <input type="text" name="years" size="12" onChange="calculate()"></font></td>
    </tr>
    <tr>
      <td colspan="3" height="26">
      <div class="result">
        <font face="Verdana" style="font-size: 9pt">
        <input type="button" value="Calcular" onClick="calculate()"> Información 
        sobre pagos:</font></div>
      </td>
    </tr>
    <tr>
      <td height="22">
      <div class="result">
        <font face="Verdana" style="font-size: 9pt">4)</font></div>
      </td>
      <td height="22">
      <div class="result">
        <font face="Verdana" style="font-size: 9pt">Pago por mes:</font></div>
      </td>
      <td height="22"><font face="Verdana" style="font-size: 9pt">
      <input type="text" name="payment" size="12"></font></td>
    </tr>
    <tr>
      <td height="22">
      <div class="result">
        <font face="Verdana" style="font-size: 9pt">5)</font></div>
      </td>
      <td height="22">
      <div class="result">
        <font face="Verdana" style="font-size: 9pt">Coste total:</font></div>
      </td>
      <td height="22"><font face="Verdana" style="font-size: 9pt">
      <input type="text" name="total" size="12"></font></td>
    </tr>
    <tr>
      <td height="22">
      <div class="result">
        <font face="Verdana" style="font-size: 9pt">6)</font></div>
      </td>
      <td height="22">
      <div class="result">
        <font face="Verdana" style="font-size: 9pt">Interés total:</font></div>
      </td>
      <td height="22"><font face="Verdana" style="font-size: 9pt">
      <input type="text" name="totalinterest" size="12"></font></td>
    </tr>
  </table>
</form>
<script type="text/javascript">
function calculate() {
  var principal = document.loandata.principal.value;
  var interest  = document.loandata.interest.value / 100 / 12;
  var payments  = document.loandata.years.value * 12;
  var x         = Math.pow(1 + interest, payments);
  var monthly   = (principal*x*interest)/(x-1);
  if (!isNaN(monthly) &&
      (monthly != Number.POSITIVE_INFINITY) &&
	  (monthly != Number.NEAGTIVE_INFINITY)) {
    document.loandata.payment.value=Math.round(monthly);
	document.loandata.total.value=Math.round(monthly*payments);
	document.loandata.totalinterest.value=Math.round((monthly*payments) - principal);
  }
  else {
    document.loandata.payment.value="";
	document.loandata.total.value="";
	document.loandata.totalinterest.value="";
  }
}
function round(x) {return Math.round(x *100)/100;}
</script>

</body>

</html>