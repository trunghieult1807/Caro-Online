var timer = {
  setTimer: function(timer1, timer2) {
    var x = setInterval(
      function() {
        if (currGame.Turn == 1) {
          timer1 -= 1;
        }
        var minutes = Math.floor(timer1/60);
        var seconds = Math.floor(timer1%60);

        document.getElementById("oppo1-time").textContent = String('00' + minutes).slice(-2) + ":" + String('00' + seconds).slice(-2);

        // If the count down is over, write some text
        if (timer1 < 0) {
          clearInterval(x);
          //document.getElementById("oppo1-time").textContent = "EXPIRED";
        }
      }, 1000
    );

    var y = setInterval(
      function() {
        if (currGame.Turn == 2) {
          timer2 -= 1;
        }
        var minutes = Math.floor(timer2/60);
        var seconds = Math.floor(timer2%60);

        document.getElementById("oppo2-time").textContent = String('00' + minutes).slice(-2) + ":" + String('00' + seconds).slice(-2);

        // If the count down is over, write some text
        if (timer2 < 0) {
          clearInterval(y);
          document.getElementById("oppo2-time").textContent = "EXPIRED";
        }
      }, 1000
    );
  },

  clearTimer: function() {

  },
};
// var timer1 = 300;
//
// if(timer1 < 5) {
//   clearTimer(myVar);
// }
//
// function setTimer() {
//   if (currGame.Turn == 1) {
//     timer1 -= 1;
//   }
//   var minutes = Math.floor(timer1/60);
//   var seconds = Math.floor(timer1%60);
//
//   document.getElementById("oppo1-time").textContent = String('00' + minutes).slice(-2) + ":" + String('00' + seconds).slice(-2);
//
//   // If the count down is over, write some text
//   if (timer1 < 5) {
//
//   }
// }
//
// function clearTimer(myVar) {
//   clearInterval(myVar);
//   document.getElementById("oppo1-time").textContent = "";
// }
