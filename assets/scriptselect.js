jQuery(document).ready(function () {
  var minDate, maxDate;
  mini = new DateTime($("#start_date"), {
    format: "YYYY-MM-DD HH:mm",
  });
  maxi = new DateTime($("#end_date"), {
    format: "YYYY-MM-DD HH:mm",
  });

  $("#btn_search").on("click", function (event) {
    event.preventDefault();
    minDate = $("#start_date").val();
    maxDate = $("#end_date").val();
    submit_date(minDate, maxDate);
  });

  function submit_date(start, end) {
    var start_date = start;
    var end_date = end;
    $("#ipTable").DataTable().destroy();
    var filterDateTable = $("#ipTable").DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      dom: "Blfrtip",
      lengthMenu: [
        [15, 25, 50, -1],
        [15, 25, 50, "All"],
      ],
      paging: true,
      buttons: [
        {
          extend: "excel",
          text: "Export as Excel",
          exportOptions: {
            modifier: {
              page: "All",
            },
          },
        },
      ],
      searching: true,
      filter: true,
      ajax: {
        url: "admin-ajax.php",
        type: "POST",
        data: {
          action: "ajax_hundler_admin",
          searchByFromdate: start_date,
          searchByTodate: end_date,
        },
      },
      columns: [
        { data: "id" },
        { data: "ip" },
        { data: "country" },
        { data: "city" },
        { data: "longitude" },
        { data: "latitude" },
        { data: "visited_page" },
        { data: "time_stamp" },
      ],
      select: {
        style: "multi",
        selectRow: true,
      },
    });
    filterDateTable.on("draw.dt", function () {
      var info = filterDateTable.page.info();
      filterDateTable
        .column(0, { search: "applied", order: "applied", page: "applied" })
        .nodes()
        .each(function (cell, i) {
          cell.innerHTML = i + 1 + info.start;
        });
    });
  }

  var recordTable = $("#ipTable").DataTable({
    responsive: true,
    dom: "Blfrtip",
    lengthMenu: [
      [15, 25, 50, -1],
      [15, 25, 50, "All"],
    ],
    buttons: [
      {
        extend: "excel",
        text: "Export as Excel",
        exportOptions: {
          modifier: {
            page: "all",
          },
        },
      },
    ],
    processing: true,
    serverSide: true,
    paging: true,
    searching: true,
    filter: true,
    ajax: {
      url: "admin-ajax.php",
      data: {
        action: "ajax_hundler_admin",
      },
      type: "POST",
    },
    columns: [
      { data: "id" },
      { data: "ip" },
      { data: "country" },
      { data: "city" },
      { data: "longitude" },
      { data: "latitude" },
      { data: "visited_page" },
      { data: "time_stamp" },
    ],
    select: {
      style: "multi",
      selectRow: true,
    },
  });

  recordTable.on("draw.dt", function () {
    var info = recordTable.page.info();
    recordTable
      .column(0, { search: "applied", order: "applied", page: "applied" })
      .nodes()
      .each(function (cell, i) {
        cell.innerHTML = i + 1 + info.start;
      });
  });
});
