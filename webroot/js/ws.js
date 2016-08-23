
var popedup;
function popup(pp) {
    // console.log(document.getElementById(pp));
    document.getElementById(pp).style.display='block';
    document.getElementById('popup_overlay').style.display='block';

    popedup = pp;
}
function help(pp) {
    console.log(document.getElementById(pp));
    document.getElementById(pp).style.display='block';
    // document.getElementById('popup_help').style.display='block';

    popedup = pp;
    // console.log(pp);
}

function close_popup() {
    document.getElementById(popedup).style.display='none';
    document.getElementById('popup_overlay').style.display='none';
}

// CALCUL BUY PRICE
// with Id and Num
function displayTotal (theid, price, type){
    var cost = price * document.getElementById(theid).value;
    var fees = cost * 0.05 + 1;
    document.getElementById("cost").innerHTML = cost;
    document.getElementById("fees").innerHTML = fees.toFixed(2);
    document.getElementById("total").innerHTML = (type == '2')? (cost-fees).toFixed(2) : (cost+fees).toFixed(2);
    document.getElementById("totalCost").style.visibility = 'visible';
}
// with 2 ID's
function displayTotal2 (theid, theid2){
    document.body.addEventListener ('keyup', function(event) {
        fillTotalResult(theid, theid2)
    }, true);
    document.getElementById(theid).onclick = function(){
        fillTotalResult(theid, theid2)
    };
}
function fillTotalResult(theid, theid2){
    var cost = document.getElementById(theid2).value * document.getElementById(theid).value;
    var str = cost.toFixed(2) + ' + fees ' + (cost * 0.01 + 2).toFixed(2);
    document.getElementById("totalResult").innerHTML = str + ' = ' + (cost + cost * 0.01 + 1).toFixed(2);
}

// --
function get_code (Pformat, Pid, Pname){
    /*if (Pformat != '' && Pid != '' && Pname != ''){
		if (texte = file ('lib/getcode.php?Gformat=' + Pformat + '&Gid=' + Pid + '&Gname=' + Pname)){
			//writediv (texte);			
		}
	}*/
}

/*function sendTeamRequest() {
    FB.ui({method: 'apprequests',
        message: '<?php echo h(__('Im building a team of traders. Do you want to join?')); ?>',
        filters: [{name: 'Suggested', user_ids: <?php echo $app_user; ?>}]
    }, requestCallback2);
}*/

function requestCallback2(response) {
    //console.log(response);
}
// ---

function file (php_file){
    var xhr_object;
	if (window.XMLHttpRequest) // FIREFOX
	xhr_object = new XMLHttpRequest ();
	else if (window.ActiveXObject) // IE
	xhr_object = new ActiveXObject ("Microsoft.XMLHTTP");
	else
	return (false);
    
	xhr_object.open ("GET", php_file, false);
	xhr_object.send (null);
	if (xhr_object.readyState == 4) return (xhr_object.responseText);
	else return (false);
}
