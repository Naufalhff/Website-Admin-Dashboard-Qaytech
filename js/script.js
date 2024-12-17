$(document).ready(function () {
  function fetchData() {
    $.ajax({
      url: "fetch_data.php",
      type: "GET",
      success: function (data) {
        $("#c4ytable").html(data); // Update the entire div with new data
      },
      error: function (xhr, status, error) {
        console.error("Error fetching data: ", error); // Log any errors
      },
    });
  }

  function fetchData2() {
    $.ajax({
      url: "get_data.php",
      type: "GET",
      success: function (data) {
        $("#c3ytable").html(data); // Update the entire div with new data
      },
      error: function (xhr, status, error) {
        console.error("Error fetching data: ", error); // Log any errors
      },
    });
  }

  fetchData(); // Initial fetch to load data immediately
  fetchData2(); // Initial fetch to load data immediately

  setInterval(fetchData, 500); // Check for new data every 2 seconds
  setInterval(fetchData2, 500); // Check for new data every 2 seconds
});

function incrementCounter(button) {
  let counterElement = button.previousElementSibling;
  let counter = parseInt(counterElement.textContent);
  counter++;
  counterElement.textContent = counter;
  button.nextElementSibling.value = counter; // Update hidden input value
}

function decrementCounter(button) {
  let counterElement = button.nextElementSibling;
  let hiddenInput =
    button.nextElementSibling.nextElementSibling.nextElementSibling;
  let counter = parseInt(counterElement.textContent);
  counter--;
  if (counter < 0) {
    counter = 0;
  }
  counterElement.textContent = counter;
  hiddenInput.value = counter; // Update hidden input value
}
$(document).ready(function () {
  $("#dataForm").submit(function (e) {
    e.preventDefault();
    var formData = $(this).serializeArray();

    // Debug: log form data
    console.log(formData);

    // Mengumpulkan data untuk dikirim ke server
    var serializedData = {};
    $.each(formData, function (i, field) {
      if (serializedData[field.name]) {
        if (!Array.isArray(serializedData[field.name])) {
          serializedData[field.name] = [serializedData[field.name]];
        }
        serializedData[field.name].push(field.value);
      } else {
        serializedData[field.name] = field.value;
      }
    });

    console.log(serializedData); // Debug: log serialized data

    $.ajax({
      type: "POST",
      url: "save_data.php", // URL untuk save_data.php
      data: serializedData,
      dataType: "json",
      success: function (response) {
        console.log(response); // Debug: log response data
        if (response.success) {
          $("#successModal").modal("show");
        } else {
          alert("Terjadi kesalahan saat menyimpan data: " + response.message);
        }
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText); // Debug: log error response
        alert("Terjadi kesalahan saat menyimpan data: " + error);
      },
    });
  });

  // Handle modal "Oke" button click
  $("#okButton").click(function () {
    $("#successModal").modal("hide");
  });

  // Auto refresh page after modal is hidden
  $("#successModal").on("hidden.bs.modal", function () {
    location.reload();
  });
});

// export excel
document
  .getElementById("exportExcelBtn")
  .addEventListener("click", function () {
    exportTableToExcel("student_list", "data_export");
  });

function exportTableToExcel(tableID, filename = "") {
  var dataType =
    "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=UTF-8";
  var tableSelect = document.getElementById(tableID);
  var tableHTML = tableSelect.outerHTML.replace(/ /g, "%20");

  var downloadLink;
  filename = filename ? filename + ".xlsx" : "excel_data.xlsx";

  downloadLink = document.createElement("a");
  document.body.appendChild(downloadLink);

  var wb = XLSX.utils.table_to_book(tableSelect, { sheet: "Sheet1" });
  var wbout = XLSX.write(wb, { bookType: "xlsx", type: "binary" });

  function s2ab(s) {
    var buf = new ArrayBuffer(s.length);
    var view = new Uint8Array(buf);
    for (var i = 0; i < s.length; i++) view[i] = s.charCodeAt(i) & 0xff;
    return buf;
  }

  var blob = new Blob([s2ab(wbout)], { type: dataType });

  if (navigator.msSaveOrOpenBlob) {
    navigator.msSaveOrOpenBlob(blob, filename);
  } else {
    downloadLink.href = URL.createObjectURL(blob);
    downloadLink.download = filename;
    downloadLink.click();
  }

  document.body.removeChild(downloadLink);
}

// //
// document.getElementById("exportButton").addEventListener("click", function () {
//   // Mendapatkan tabel
//   var table = document.querySelector(".student_list");
//   var rows = Array.from(table.rows);
//   var csvContent = "data:text/csv;charset=utf-8,";

//   // Mengonversi setiap baris tabel menjadi format CSV
//   rows.forEach(function (row) {
//     var cols = Array.from(row.querySelectorAll("td, th"));
//     var rowData = cols
//       .map(function (col) {
//         return col.innerText; // Ambil teks dari setiap sel
//       })
//       .join(",");
//     csvContent += rowData + "\r\n"; // Tambahkan baris ke konten CSV
//   });

//   // Membuat link untuk mengunduh file
//   var encodedUri = encodeURI(csvContent);
//   var link = document.createElement("a");
//   link.setAttribute("href", encodedUri);
//   link.setAttribute("download", "data_export.csv");
//   document.body.appendChild(link); // Dapatkan link ke dalam dokumen

//   link.click(); // Klik link untuk mengunduh
//   document.body.removeChild(link); // Hapus link setelah mengunduh
// });
