document.addEventListener('DOMContentLoaded', function() {
  var Timer = function(timerStartTime, auctionEndTime, endMessage, outputDestination) {
    this.timerStartTime = timerStartTime;
    this.auctionEndTime = auctionEndTime;
    this.endMessage = endMessage;
    this.outputDestination = outputDestination;
  };
  
  Timer.prototype.countDown = function() {
    var auctionEndTime = new Date(this.auctionEndTime);
    var oneDay = 24 * 60 * 60 * 1000;
    var countDownTimer = document.getElementById(this.outputDestination);
    var endMessage = this.endMessage;
    var currentTimeCD = new Date(this.timerStartTime);
    var untilEndTime = new Date();
    var d = 0;
    var h = 0;
    var m = 0;
    var s = 0;

    setInterval(calculateTime, 1000);

    function calculateTime() {
      auctionEndTime -= 1000;
      untilEndTime = auctionEndTime - currentTimeCD;

      d = Math.floor(untilEndTime / oneDay);
      h = Math.floor((untilEndTime % oneDay) / (60 * 60 * 1000));
      m = Math.floor((untilEndTime % oneDay) / (60 * 1000)) % 60;
      s = Math.floor((untilEndTime % oneDay) / 1000) % 60 % 60;

      showTime();
    }

    function showTime() {
      if (currentTimeCD < auctionEndTime) {
        countDownTimer.innerHTML
        = d + '日' + h + '時間' + m + '分' + s + '秒';
      } else {
        countDownTimer.innerHTML = endMessage;
      }
    }
  }
  var myTimer = new Timer(currentTime, endTime, '終了！', 'timer');
  myTimer.countDown();
}, false)