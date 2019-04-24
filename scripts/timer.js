sessionStorage.setItem("duration","10");
 
 var add_minutes=function(dt,minutes){
  return new Date(dt.getTime()+minutes*60000);
};
sessionStorage.setItem("deadline", add_minutes(new Date(),duration).getTime());
 
var x = setInterval(function() {
 
var now = new Date().getTime();
var t =  sessionStorage.getItem("deadline") - now;
sessionStorage.setItem("hours", Math.floor((t%(1000 * 60 * 60 * 24))/(1000 * 60 * 60)) );
sessionStorage.setItem("minutes",Math.floor((t % (1000 * 60 * 60)) / (1000 * 60)));
sessionStorage.setItem("seconds", Math.floor((t % (1000 * 60)) / 1000));
document.getElementById("hour").innerHTML =hours;
document.getElementById("minute").innerHTML = minutes; 
document.getElementById("second").innerHTML =seconds; 
if (t < 0) {
        clearInterval(x);
        document.getElementById("stop").innerHTML = "TIME UP";
        document.getElementById("hour").innerHTML ='0';
        document.getElementById("minute").innerHTML ='0' ; 
        document.getElementById("second").innerHTML = '0'; }
}, 1000);

