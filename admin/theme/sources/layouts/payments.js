$(document).ready(function () {
    $.ajax({
      type: "POST",
      url: "/admin/libs/includes/packages/ajax/payments.php",
      data: { id: "0" },
      success: function (result) {
        var $statisticsValue = JSON.parse(result);
        $('[server-data="allEarn"]').html($statisticsValue.allEarn + $languages["currencyIcon"]);
        $('[server-data="yearEarn"]').html($statisticsValue.yearEarn + $languages["currencyIcon"]);
        $('[server-data="monthEarn"]').html($statisticsValue.monthEarn + $languages["currencyIcon"]);
        $('[server-data="todayEarn"]').html($statisticsValue.todayEarn + $languages["currencyIcon"]);
      }
    });
});
  