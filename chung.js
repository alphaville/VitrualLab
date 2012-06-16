function wait(){
    waitforme = document.getElementById("pleasewait");
    waitforme.style.display="block";
}
function done(){   
    waitforme = document.getElementById("pleasewait");
    waitforme.style.display="none";
}

/*
 * @param data
 *      Incoming data from the web service
 * @return
 *      It formats and displays the response curve.
 */
function display_response(data){
    var responseResultsDiv = document.getElementById('response_results');    
    var response = data.response;
    if (!response.success){
        alert("Error:\n"+response.error);
        done();
    }
    var d1 = [];
    time = response.t;    
    y = response.y;       
    for (var i = 0; i < time.length; i += 1){
        d1.push([time[i], y[i]]);
    }        
    var options = {
        series: {lines: {show: true},points: {show: false}},
        legend: {noColumns: 2,backgroundOpacity:0.6},
        grid: {hoverable: true, clickable: true},
        selection: {mode: "x"}
    };    
    var placeholder = $("#placeholder");
    // React to plot selection
    placeholder.bind("plotselected", function (event, ranges) {
        plot = $.plot(placeholder, [d1],
            $.extend(true, {}, options, {
                xaxis: {
                    min: ranges.xaxis.from, 
                    max: ranges.xaxis.to
                }
            }));
    });    
    // Read position of the mouse pointer
    placeholder.bind("plothover", function (event, pos, item) {
        $("#x").text(pos.x.toFixed(3));
        $("#y").text(pos.y.toFixed(4));
    });      
    responseResultsDiv.style.display = 'block';    
    var plot = $.plot(placeholder, [{
        data:d1,  
        label:'Step Response'
    }],options);
    plot.draw();              
    done();
}

function display_bode(response_data){
    var bodeplaceholder = document.getElementById('bodeplaceholder');
    bodeplaceholder.style.display = 'none';
    // Bode Plot:
    P_ = '['+response_data.response.P_+']';
    Q_ = '['+response_data.response.Q_+']';
    alert("P="+P_+"\nQ="+Q_);
    var bodeUrl = '/engine/smt6565.php?id=example&write_to_file=0&P='+encodeURIComponent(P_)+'&Q='+
    encodeURIComponent(Q_)+'&delay='+response_data.response.delay+
    '&sim_points=1500&sim_log_range='+encodeURIComponent('[-2 4]');    
    $.ajax({        
        url: bodeUrl,
        type: 'GET',
        error: function() {
            alert('WS Failure!!!\n Please contact the system admins.');
            done();
        },
        success: function() {
        //alert('SUCCESS');
        }
    }).done(function(data){
        var data_magnitude = [];
        var data_phase = [];
        var plot;
        log_omega = data.bode.log_omega;    
        magnitude = data.bode.magnitude;       
        phase= data.bode.phase;   
        for (var i = 0; i < log_omega.length; i += 1){
            data_magnitude.push([log_omega[i], magnitude[i]]);
            data_phase.push([log_omega[i], phase[i]]);
        }        
        
        var options_bode = {
            series: {lines: {show: true}},
            legend: {noColumns: 1,backgroundOpacity:0.6},
            yaxes: [ {transform: function (v) {return Math.pow(10,v);},
                      inverseTransform: function (v) {return Math.log(v)/Math.LN10;}},
                  {alignTicksWithAxis: 1,position: "right", tickFormatter: 
                          function(v,axis){return v.toFixed(axis.tickDecimals) +"rad";}} ],
            crosshair: {mode: "x"},
            grid: {hoverable: true, autoHighlight: false}
        };
            
        var bode_plot_placeholder = $("#bodeplaceholder");
        plot = $.plot(bode_plot_placeholder, [{
            data:data_magnitude,  
            label:'log M(w) = -0.000',
            color:'red'
        },{
            data:data_phase,  
            label:'Arg(w) = -0.00',
            yaxis: 2,color:'green'
        }],options_bode);
        plot.draw();           
    
        var legends = $("#bodeplaceholder .legendLabel");
        var updateLegendTimeout = null;
        var latestPosition = null;
    
        function updateLegend() {
            updateLegendTimeout = null;
            var pos = latestPosition;
            var axes = plot.getAxes();
            if (pos.x < axes.xaxis.min || pos.x > axes.xaxis.max ||
                pos.y < axes.yaxis.min || pos.y > axes.yaxis.max)
                return;

            var i, j, dataset = plot.getData();
            for (i = 0; i < dataset.length; ++i) {
                var series = dataset[i];

                // find the nearest points, x-wise
                for (j = 0; j < series.data.length; ++j)
                    if (series.data[j][0] > pos.x)
                        break;

                // now interpolate
                var y, p1 = series.data[j - 1], p2 = series.data[j];
                if (p1 == null)
                    y = p2[1];
                else if (p2 == null)
                    y = p1[1];
                else
                    y = p1[1] + (p2[1] - p1[1]) * (pos.x - p1[0]) / (p2[0] - p1[0]);
                if (i==0){
                    legends.eq(i).text(series.label.replace(/=.*/, "= " + (Math.log(y)/Math.LN10).toFixed(3)));
                }else{
                    legends.eq(i).text(series.label.replace(/=.*/, "= " + y.toFixed(2)));
                    $("#w_freq").text(Math.pow(10,p1[0]).toFixed(3));
                }
            }
        }
        
        $("#bodeplaceholder").bind("plothover", function (event, pos, item) {
            latestPosition = pos;
            if (!updateLegendTimeout)
                updateLegendTimeout = setTimeout(updateLegend, 50);
        });
        
    });
    bodeplaceholder.style.display = 'block';
}

function run_engine(){        
    wait();
    //TODO: replace with 'response_results''
    var responseResultsDiv = document.getElementById('response_results');
    responseResultsDiv.style.display='none';

    // Read parameters provided by the user
    P=$("#ps").val();
    Q=$("#qs").val();
    Kc=$("#Kc").val();
    ti=$("#ti").val();
    td=$("#td").val();
    horizon=$('#horizon').val();
    sim_points=$('#simpoints').val();   
    delay=$("#delay").val();
    closed_loop = !$("#open").is(':checked');
    do_bode = $("#bode").is(':checked');
    excitation= $('#selectInputSignal option:selected').text().trim().toLowerCase();
    frequency=$("#freq").val();
    // Calculate the transfer function of the controller (num+den).
    if (ti=='infty'){
        if (td!=0){
            Pc="["+(Kc*td)+" "+Kc+"]";
        }else{
            Pc="["+Kc+"]";
        }
        Qc="[1]";        
    }else{
        Pc="["+(td!=0?(Kc*ti*td):"")+" "+(Kc*ti) + " "+Kc+"]";
        Qc="["+ti+" 0]";
    }
    var myurl = '/engine/smt9901.php?id=example&write_to_file=1&P='+encodeURIComponent(P)+'&Q='+
    encodeURIComponent(Q)+'&Pm=1&Qm=1&Pc='+encodeURIComponent(Pc)+'&Qc='+
    encodeURIComponent(Qc)+'&delay='+delay+"&closed_loop="+
    (closed_loop?"1":"0")+"&excitation="+excitation;
    if (horizon!='auto'){
        myurl+='&sim_horizon='+horizon;
    }
    if (sim_points!='auto'){                
        myurl+='&sim_points='+(parseInt(sim_points)>20000?20000:sim_points);
    }
    if (excitation=='harmonic'){
        myurl+='&frequency='+frequency;
    }
    // Perform request against the WS
    $.ajax({        
        url: myurl,
        type: 'GET',
        error: function() {
            alert('WS Failure!!!\n Please contact the system admins.');
            done();
        },
        success: function() {}
    }).done(function(data){        
        display_response(data);
        if (do_bode){display_bode(data);}        
    });
    
    
};

function loadMe(){
    if (document.getElementsByClassName == undefined) {
        document.getElementsByClassName = function(className)
        {
            var hasClassName = new RegExp("(?:^|\\s)" + className + "(?:$|\\s)");
            var allElements = document.getElementsByTagName("*");
            var results = [];

            var element;
            for (var i = 0; (element = allElements[i]) != null; i++) {
                var elementClass = element.className;
                if (elementClass && elementClass.indexOf(className) != -1 && hasClassName.test(elementClass))
                    results.push(element);
            }
            return results;
        }
    }
}
// Check whether variable is OK
function checkNumeric(inputElement){
    var val = inputElement.value;
    if (val.length==0){
        document.getElementById("sb").disabled=true;
        inputElement.className='error';
    }else{
        if (isNumeric(val)==true){
            document.getElementById("sb").disabled=false;
            inputElement.className='normal';
        }else{
            document.getElementById("sb").disabled=true;
            inputElement.className='error';
        }
    }
}


function checkSign(inputElement,strict){
    var val = inputElement.value;
    if (val.length==0){
        document.getElementById("sb").disabled=true;
        inputElement.className='errortiny';		
    }else{
        var flag = false;
        if (strict==1)
        {
            flag = isNumeric(val)==true && val>0;
        }else if (strict==0)
        {
            flag = isNumeric(val)==true && val>=0;
        }else
        {
            flag = isNumeric(val);
        }
        if (flag){
            document.getElementById("sb").disabled=false;
            inputElement.className='tinyInput';
        }else{
            document.getElementById("sb").disabled=true;
            inputElement.className='errortiny';
        }
    }
}

function checkTi(inputElement){
    var val = inputElement.value;
    if (val.length==0){
        document.getElementById("sb").disabled=true;
        inputElement.className='error';
    }else{
        if (isNumeric(val)==true||val=='infty'){
            document.getElementById("sb").disabled=false;
            inputElement.className='normal';
        }else{
            document.getElementById("sb").disabled=true;
            inputElement.className='error';
        }
    }
}

// Check whether variable is numeric
function isNumeric(x) {
    return !isNaN(parseFloat(x)) && isFinite(x);
}


// Action Upon click on the checkbox openLoop
function openLoopAction(chkBox) {
    if (chkBox.checked){
        document.getElementById("flowcharthref").href="PIDS2.png";
        document.images.flowchart.src="PIDS2.png";
        document.getElementById("openLoopHint").innerHTML="<span class=\"hotspot\" onmouseover=\"tooltip.show(\'Uncheck this box to run simulations on the closed loop system (see figure)\');\" onmouseout=\"tooltip.hide();\">Open Loop</span>";
    }else{
        document.getElementById("flowcharthref").href="PIDS.png";
        document.getElementById("flowcharthref").href="PIDS.png";
        document.images.flowchart.src="PIDS.png";
        document.getElementById("openLoopHint").innerHTML="<span class=\"hotspot\" onmouseover=\"tooltip.show(\'Check this box to run simulations on the open loop system (see figure)\');\" onmouseout=\"tooltip.hide();\">Open Loop</span>";
    
    }
}


// NEW POPUP
function newPopup(url) {
    popupWindow = window.open(
        url,'popUpWindow','height=250,width=500,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=no');
}

function showAdvanced(){
    var toggleText = document.getElementById("advancedOptionsText");
    var eleBode = document.getElementById("advOptions");
    var eleSimPar = document.getElementById("simulationParameters");
    var stepEle = document.getElementById('step');
    var harmEle = document.getElementById('harmonic');
    if(eleBode.style.display != "none") {
        eleBode.style.display = "none";
        toggleText.innerHTML = "Show Advanced Options";
        stepEle.style.display="none";
        harmEle.style.display="none";
        eleSimPar.style.display="none";
    }else {
        eleBode.style.display = "inherit";
        toggleText.innerHTML = "Hide Advanced Options";
        stepEle.style.display="block";
        eleSimPar.style.display="block";
        signalParameters(document.getElementById("selectInputSignal"));
    }
}

function signalParameters(selector){
    var option = selector.options[selector.selectedIndex].value;
    var stepEle = document.getElementById('step');
    var harmEle = document.getElementById('harmonic');
    if(option=="1"){
        stepEle.style.display="block";
        harmEle.style.display="none";
    }else if (option=="2"){  
        harmEle.style.display="none";
        stepEle.style.display="none";
    }else if (option=="3"){
        harmEle.style.display="block";
        stepEle.style.display="none";
    }
}

function highlight(object){
    object.className="highlighted";
}

function dehighlight(object){
    object.className="navLink";
}

(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

!function(d,s,id){
    var js,fjs=d.getElementsByTagName(s)[0];
    if(!d.getElementById(id)){
        js=d.createElement(s);
        js.id=id;
        js.src="//platform.twitter.com/widgets.js";
        fjs.parentNode.insertBefore(js,fjs);
    }
}(document,"script","twitter-wjs");

function highlightButton(){
    var excl = document.getElementById("exclamation");
    excl.style.display="block";
}

function dehighlightButton(){
    var excl = document.getElementById("exclamation");
    excl.style.display="none";
}
