$(document).ready(function () {
    $.ajax({
      type: "POST",
      url: "/admin/libs/includes/packages/ajax/statistics.php",
      data: { id: "0" },
      success: function (result) {
        var $statisticsValue = JSON.parse(result);
        $('[server-data="totalEarn"]').html($statisticsValue.earning + $languages["currencyIcon"]);
        $('[server-data="totalSales"]').html($statisticsValue.sales);
        $('[server-data="totalRegister"]').html($statisticsValue.register);
      }
    });
});
  