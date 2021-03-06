<!-- TABLE: START -->
<table class="parameters">    
<colgroup>
<col style="width:40px">
<col  style="width:170px">
<col style="width:60px">
<col  style="width:170px">
</colgroup>
  <tr>
    <td>
      <input type="checkbox" name="open" id="open" onClick="openLoopAction(this);" <?if ($open=="1") {echo 'checked="checked"';}?> >
    </td>
    <td>
      <span id="openLoopHint"><?echo $__OPENLOOP_HTML;?></span>
    </td>
  </tr>
<tr style="height:12px"><TD></TD></tr>
	
  <tr>
    <td colspan="2">
      <small><em>PID Controller Tuning</em></small>
    </td>
<td colspan="2">
      <small><em>System Parameters</em></small>
    </td>
  </tr>
  <tr>
    <td>
      <?echo $__KC_HTML; 
      ?>
    </td>
    <td>
      <input class="normal" type="text" value="<?echo $kcval;?>" name="Kc" id="Kc" onkeyup="return checkNumeric(this);" >
    </td>
    <td>
      <?echo $__P_HTML; 
      ?>
    </td>
    <td>
      <input class="normal" type="text" value="<?echo $psval?>" name="ps" id="ps"  >
    </td>
  </tr>
  <tr>
    <td>
      <?echo $__TI_HTML; 
      ?>
    </td>
    <td>
      <input class="normal" type="text" value="<?echo $tival;?>" name="ti" id="ti" onkeyup="checkTi(this);" >
    </td>
<td>
      <?echo $__Q_HTML; 
      ?>
    </td>
    <td>
      <input class="normal" type="text" value="<?echo $qsval?>" name="qs" id="qs" >
    </td>
  </tr>
  <tr>
    <td>
      <?echo $__TD_HTML; 
      ?>
    </td>
    <td>
      <input class="normal" type="text" value="<?echo $tdval;?>" name="td" id="td" onkeyup="return checkNumeric(this);" >
    </td>
 <td>
      <?echo $__DELAY; 
      ?>
    </td>
    <td>
      <input class="normal" type="text" value="<?echo $delayval?>" name="delay" id="delay" onkeyup="return checkNumeric(this);">
    </td>
  </tr>
</table>
<!-- TABLE: END -->
