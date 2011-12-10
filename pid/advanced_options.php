<table id="advOptions" style="display:none">
<colgroup>
<col style="width:140px"/>
<col style="width:65px"/>
</colgroup>
  <tr>
    <td colspan="2">
      <small>Generated Diagrams...</small>
    </td>
  </tr>
  <tr>
    <td>
       Bode Diagram 
    </td>
    <td>
      <input type="checkbox" name="bode" id="bode" <?if ($bode=="1") {echo 'checked="true"';}?>>
    </td>
  </tr>
  <tr>
    <td>
       Nyquist Diagram 
    </td>
    <td>
      <input type="checkbox" name="nyquist" id="nyquist" <?if ($nyquist=="1") {echo 'checked="true"';}?>>
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
       Input Signal 
    </td>
    <td>
      <select class="inputSigSelector" name="selectInputSignal" id="selectInputSignal" onchange="signalParameters(this);">
      <option value="1">
         Step 
      </option><option value="2">
         Impulse 
      </option><option value="3">
         Harmonic 
      </option>
      </select>
    </td>
  </tr>
</table>


<table id="step" style="display:none;">
<colgroup>
<col style="width:140px"/>
<col style="width:60px"/>
</colgroup>
  <tr>
    <td>
       Amplitute 
    </td>
    <td>
      <input type="text" name="amplitute" id="amplitute" value="1" class="tinyInput"/>
    </td>
  </tr>
</table>


<table id="harmonic" style="display:none;">
<colgroup>
<col style="width:140px"/>
<col style="width:60px"/>
</colgroup>
  <tr>
    <td>
       Amplitute 
    </td>
    <td>
      <input type="text" name="amplitute" id="amplitute" value="1" class="tinyInput"/>
    </td>
  </tr>
  <tr>
    <td>
       Frequency 
    </td>
    <td>
      <input type="text" name="freq" id="freq" value="100" class="tinyInput"/>
    </td>
  </tr>
</table>
