<div class="advancedOptionsBlock">
  <table id="advOptions" style="display:none">
    <colgroup>
      <col style="width:150px">
      <col style="width:140px">
    </colgroup>
    <tr>
      <td colspan="2">
        <small>Generated Diagrams...</small>
      </td>
    </tr>
    <tr>
      <td>
        <label for="bode"> <?echo $__BODE_DIAG;?> </label>
      </td>
      <td>
        <input type="checkbox" name="bode" id="bode" <?if ($bode=="1") {echo 'checked="checked"';}?>>
      </td>
    </tr>
    <tr>
      <td>
         <label for="nyquist"><?echo $__NYQUIST_DIAG;?></label>
      </td>
      <td>
        <input type="checkbox" name="nyquist" id="nyquist" <?if ($nyquist=="1") {echo 'checked="checked"';}?>>
      </td>
    </tr>
    <tr>
      <td>
         &nbsp; 
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <small>Excitation...</small>
      </td>
    </tr>
    <tr>
      <td>
         <label for="selectInputSignal">Input Signal</label>
      </td>
      <td>

        <select class="inputSigSelector" name="selectInputSignal" id="selectInputSignal" onchange="signalParameters(this);">

<?  $op1 = '<option value="1">Step</option>';
    $op2='<option value="2">Impulse </option>';
    $op3='<option value="3">Harmonic</option>';
if ($selectInputSignal==1){echo $op1.$op2.$op3;}else if ($selectInputSignal==2){echo $op2.$op3.$op1;}else{echo $op3.$op2.$op1;}

?>
        

        </select>
      </td>
    </tr>
  </table>



  <table id="step" style="display:none;">
    <colgroup>
      <col style="width:150px">
      <col style="width:115px">
    </colgroup>
    <tr>
      <td>
         Amplitute 
      </td>
      <td>
        <input type="text" name="amplitude" id="amplitude" class="tinyInput"  value="<?echo $amplitude;?>" onkeyup="checkSign(this,-1);">
      </td>
    </tr>
  </table>
  <table id="harmonic" style="display:none;">
    <colgroup>
      <col style="width:150px">
      <col style="width:120px">
    </colgroup>
    <tr>
      <td>
         Amplitute 
      </td>
      <td>
        <input type="text" name="amplitude2" id="amplitute2" class="tinyInput" value="<?echo $amplitude;?>" onkeyup="checkSign(this,-1);">
      </td>
    </tr>
    <tr>
      <td>
         Frequency 
      </td>
      <td>
        <input type="text" name="freq" id="freq" value="<?echo $freq;?>" class="tinyInput" onkeyup="checkSign(this,1);">
      </td>
    </tr>
  </table>

<div class="cl"></div>

<table id="simulationParameters" style="display:none;">
    <colgroup>
      <col style="width:150px">
      <col style="width:115px">
    </colgroup>

<tr>
<td colspan="2"><small>Simulation Parameters...</small></td>
</tr>

<tr><TD>Sim. Points</TD>
<td><input type="text" value="<?echo $simpoints;?>" class="tinyInput" name="simpoints" id="simpoints" onkeyup="checkNumOrAuto(this);"></td>
</tr>

<tr><TD>Sim. Horizon</TD>
<td><input type="text" value="<?echo $horizon;?>" class="tinyInput" id="horizon" name="horizon" onkeyup="checkNumOrAuto(this);"></td>
</tr>

<tr><TD><?echo $__AXES?></TD>
<td><input type="text" value="<?echo $axes;?>" class="tinyInput" id="axes" name="axes"></td>
</tr>
</table>



</div>
