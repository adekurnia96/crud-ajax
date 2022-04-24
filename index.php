<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ajax Komentar | Sekolahkoding</title>
  <script src="../jquery-3.5.1.min.js"></script>
  <style>
    * {
      font-family: 15px;
      font-family: sans-serif;
    }

    body {
      width: 80%;
      margin: 10% auto;
    }

    button {
      background-color: red;
      color: white;
      border: none;
    }


    .box {
      border-style: solid;
      border-width: 1px;
      margin: 10px;
      padding: 4px;
    }
  </style>
</head>

<body>

  <h1>Artikel Sekolahkoding</h1>
  <p>Ini isi artikelnya, Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ea, delectus error autem neque quaerat libero recusandae dolor, quis voluptas ducimus alias dicta corrupti illo nisi nobis deserunt aperiam eos pariatur!</p>

  <textarea name="textarea_komentar" id="textarea_komen" cols="40" rows="8"></textarea><br>
  <input type="submit" name="submit_komen" id="submit_komen" value="Submit"><br><br>

  <div id="komentar_wrapper">
    <?php
    include_once 'database.php';
    $query = "SELECT * FROM komentar ORDER BY id DESC";
    $comments = mysqli_query($link, $query);
    // var_dump($_SESSION['user']);
    foreach ($comments as $comment) { ?>
      <div class="box" id="komentar_<?= $comment['id']; ?>">
        <p class="komentar_text" data-id="<?= $comment['id']; ?>"> <?= $comment['isi_komentar']; ?></p>
        <button type="button" class="hapus_komentar" data-id="<?= $comment['id']; ?>">Hapus</button>
        <button type="button" class="edit_komentar" data-id="<?= $comment['id']; ?>">Edit</button>
      </div>
    <?php } ?>
  </div>

  <script>
    // $("h1").after("<br>");

    $("#submit_komen").on('click', function() {

      var isi = $("#textarea_komen").val();

      $.ajax({
        url: "komentar_ajax.php",
        method: "POST",
        data: {
          isi_komentar: isi,
          type: "insert"
        },
        success: function(data) {
          if (data == '0') {
            alert('Anda harus login!');
          } else {
            $("#textarea_komen").val("");
            $("#komentar_wrapper").prepend(data);
          }
        }
      });

    });

    $(document).on('click', '.hapus_komentar', function() {
      var id = $(this).attr('data-id');
      $.ajax({
        url: "komentar_ajax.php",
        method: "POST",
        data: {
          id_komen: id,
          type: "delete"
        },
        success: function(data) {
          if (data == '0') {
            alert('Anda harus login!');
          } else {
            $("#komentar_" + id).fadeOut();
          }
        }
      });
    });

    $(document).on('click', '.komentar_text', function() {
      var id = $(this).attr('data-id');
      console.log(id);
      var textbox = $(document.createElement('textarea')).attr('id', 'textarea_' + id);
      $(this).replaceWith(textbox);
      // $("#textarea_" + id).after("<br/>");
    });

    $(document).on('click', '.edit_komentar', function() {
      var id = $(this).attr('data-id');
      var isi = $('#textarea_' + id).val();
      console.log(isi);
      if (isi !== undefined && isi !== "") {

        var text = $(document.createElement('p')).attr({
          'id': 'komentar_' + id,
          'class': 'komentar_text',
          'data-id': id
        }).text(isi);

        $.ajax({
          url: "komentar_ajax.php",
          method: "POST",
          data: {
            isi_komen: isi,
            id_komen: id,
            type: "update"
          },
          success: function(data) {
            console.log(data);
            if (data == '0') {
              alert('Anda harus login!');
            } else {
              $('#textarea_' + id).replaceWith(text);
            }
          }
        });

      }

    });
  </script>

</body>

</html>