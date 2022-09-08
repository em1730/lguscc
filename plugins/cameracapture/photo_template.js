
        const webcamElement = document.getElementById('webcam');
        const canvasElement = document.getElementById('canvas');
        const snapSoundElement = document.getElementById('snapSound');
        const webcam = new Webcam(webcamElement, 'user', canvasElement, snapSoundElement);

        
        function take_snapshot() {
            // // take snapshot and get image data
        
            let picture = webcam.snap();
            document.querySelector('#photo').src = picture;
            $(".image-tag").val(picture);
            $("#canvas").attr("hidden", true);
            webcam.stop();
            $("#canvas").hide();
            $("#webcam").hide();
            $("#photo").show();
        }

        $(document).ready(function() {
            
            $("#fileToUpload").change(function(e) {
          
                var img = e.target.files[0];
                22
                if (!pixelarity.open(img, false, function(res) {
                        23
                        $("#photo").attr("src", res);
                        $(".image-tag").attr("value", res);
                    }, "jpg", 0.7)) {
                    25
                    alert("Whoops! That is not an image!");
                    26
                }
                  
                $("#photo").show();
                $("#canvas").hide();
                $("#webcam").hide();
               
            });
            
            

            $("#crop").click(function(e) {
            

                var img = $("#photo").attr("src");
              
                console.log(img);
                if (!pixelarity.open(img, true, function(res) {
                        23
                        $("#photo").attr("src", res);
                        24
                    }, "jpeg", 0.7)) {
                    25
                    alert("Whoops! That is not an image!");
                    26

                }
            });
 
            $("#opencamera").click(function() {
                $("#canvas").show();
                $("#webcam").show();
                $('#canvas').removeAttr('hidden');
                $('#webcam').removeAttr('hidden');
                $("#photo").hide();
                webcam.start()
                    .then(result => {
                        console.log("webcam started");
                    })
                    .catch(err => {
                        console.log(err);
                    })
            });
          
        });