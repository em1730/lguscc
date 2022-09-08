<?php

// include('includes/head.php');


include('credentials.php');



?>




















<script>
  // $('#scan_track').on('change',function(){

  //   // function receive(){
  //              var docno = document.getElementById("scan_track").value;

  //             //  alert (docno);

  //             $.ajax({
  //               type:'POST',
  //               data:{docno:docno},
  //               url:'scan_track.php',
  //                success:function(data){
  //                 var result = $.parseJSON(data);
  //                 // alert(result.type)
  //                  document.getElementById('lblDate').innerHTML = result.date;
  //                  document.getElementById('lblTime').innerHTML = result.time;
  //                  document.getElementById('lblType').innerHTML = result.type;
  //                  document.getElementById('lblParticulars').innerHTML = result.particulars;
  //                  document.getElementById('lblOrigin').innerHTML = result.origin;
  //                  document.getElementById('lblDestination').innerHTML = result.destination;
  //                  document.getElementById('lblRemarks').innerHTML = result.remarks;
  //                  document.getElementById('lblMessage').innerHTML = result.message;

  //                }

  //                 });   

  //                 document.getElementById('scan_track').focus();
  //                 document.getElementById('scan_track').select();

  //                 //


  //     });

  $('#update_obr').on('change', function() {

    // function receive(){
    var obr = document.getElementById("update_obr").value;

    //  alert (docno);

    $.ajax({
      type: 'POST',
      data: {
        obr: obr
      },
      url: 'update_obr.php',
      success: function(data) {
        var result = $.parseJSON(data);
        alert(data)
        //  document.getElementById('lblDate').innerHTML = result.date;
        //  document.getElementById('lblTime').innerHTML = result.time;
        //  document.getElementById('lblType').innerHTML = result.type;
        //  document.getElementById('lblParticulars').innerHTML = result.particulars;
        //  document.getElementById('lblOrigin').innerHTML = result.origin;
        //  document.getElementById('lblDestination').innerHTML = result.destination;
        //  document.getElementById('lblRemarks').innerHTML = result.remarks;
        //  document.getElementById('lblMessage').innerHTML = result.message;

      }

    });

    // document.getElementById('scan_track').focus();
    // document.getElementById('scan_track').select();

    //


  });

  $('#update_prevobr').on('change', function() {

    // function receive(){
    var obr = document.getElementById("update_prevobr").value;

    //  alert (docno);

    $.ajax({
      type: 'POST',
      data: {
        obr: obr
      },
      url: 'update_prevobr.php',
      success: function(data) {
        var result = $.parseJSON(data);
        alert(data)
        //  document.getElementById('lblDate').innerHTML = result.date;
        //  document.getElementById('lblTime').innerHTML = result.time;
        //  document.getElementById('lblType').innerHTML = result.type;
        //  document.getElementById('lblParticulars').innerHTML = result.particulars;
        //  document.getElementById('lblOrigin').innerHTML = result.origin;
        //  document.getElementById('lblDestination').innerHTML = result.destination;
        //  document.getElementById('lblRemarks').innerHTML = result.remarks;
        //  document.getElementById('lblMessage').innerHTML = result.message;

      }

    });

    // document.getElementById('scan_track').focus();
    // document.getElementById('scan_track').select();

    //

    location.reload();
  });

  $('#update_dv').on('change', function() {

    // function receive(){
    var dv = document.getElementById("update_dv").value;

    //  alert (docno);

    $.ajax({
      type: 'POST',
      data: {
        dv: dv
      },
      url: 'update_dv.php',
      success: function(data) {
        var result = $.parseJSON(data);
        alert(data)
        //  document.getElementById('lblDate').innerHTML = result.date;
        //  document.getElementById('lblTime').innerHTML = result.time;
        //  document.getElementById('lblType').innerHTML = result.type;
        //  document.getElementById('lblParticulars').innerHTML = result.particulars;
        //  document.getElementById('lblOrigin').innerHTML = result.origin;
        //  document.getElementById('lblDestination').innerHTML = result.destination;
        //  document.getElementById('lblRemarks').innerHTML = result.remarks;
        //  document.getElementById('lblMessage').innerHTML = result.message;

      }

    });

    // document.getElementById('scan_track').focus();
    // document.getElementById('scan_track').select();

    //


  });
</script>