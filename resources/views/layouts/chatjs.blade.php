<script>
    let Toast, Toast2;
    $(function () {
        // initialize tooltip
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

        // initialize sweetalert2
        Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        // check file selection
        const label_tooltip = bootstrap.Tooltip.getInstance('#labelImage');
        $("#image").change(function () {
            name = $(this).val().replace(/C:\\fakepath\\/i, '');
            label_tooltip.setContent({ '.tooltip-inner': name + ' selected' });
        });

        // message form submit handler
        $("#messageForm").submit(function (e) {
            e.preventDefault();
            $("#noMessagesDiv").addClass('d-none');
            $("#btnSubmit").html(`<i class="fas fa-spinner fa-spin"></i>`)
            $("#btnSubmit").addClass('disabled');
            let formdata = new FormData(this);
            let message = $(`#messageForm :input[name="message"]`).val();
            let image = $(`#messageForm :input[name="image"]`).val();

            // append message
            if (message !== "") appendMessage(message, image)
            // sending message
            Swal.fire({
                width: "10%",
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
            });
            Swal.showLoading();
            sendMessage(formdata);
        });

    });

    function sendMessage(formdata) {
        $.ajax({
            url: '{{ route('chat.store') }}', // Replace with your API endpoint
            type: 'POST',
            data: formdata,
            contentType: false, // Set to false for FormData
            processData: false, // Set to false for FormData
            success: function(response) {
                // displaying received response
                appendResponse(response);
                // reset form
                $(`#messageForm :input[name="message"]`).val("");
                $(`#messageForm :input[name="image"]`).val("")

                // btn cleanup
                $("#btnSubmit").removeClass('disabled');
                $("#btnSubmit").html(`<i class="far fa-paper-plane"></i>`)

                // close alert
                Swal.close();
            },
            error: function(error) {
                // close alert
                Swal.close();
                if (error.status === 422) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.responseJSON.message
                    })
                }else {
                    Toast.fire({
                        icon: 'error',
                        title: 'something went wrong, please try again!'
                    })
                }

                // btn cleanup
                $("#btnSubmit").removeClass('disabled');
                $("#btnSubmit").html(`<i class="far fa-paper-plane"></i>`)
            }
        });
    }

    function appendMessage(message, image) {
        let html = `<div class="direct-chat-msg right">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-timestamp float-left">--</span>
                    </div>
                    <img class="direct-chat-img" src="{{ asset("assets/user36.png") }}" alt="message user image">
                    <div class="direct-chat-text bg-gray-dark">
                        ${message}`;
        if(image !== "" || image === undefined) {
            html += `
            <div class="row">
                <div class="col-2"></div>
                <img id="uplodedImage" class=" col-8 img-fluid mt-3 mb-2">
                            <div class="col-2"></div>
                        </div>
            </div>
        </div>`;
        }else {
            html += `</div></div>`;
        }

        $("#messageViewer").append(html);

        if(image !== "" || image === undefined) {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("image").files[0]);

            oFReader.onload = function (oFREvent) {
                document.getElementById("uplodedImage").src = oFREvent.target.result;
            };
        }

        $('html, body').animate({ scrollTop: $(document).height() }, 'fast');
    }

    function appendResponse(message) {
        console.log(message)
        let html = `<div class="direct-chat-msg">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-timestamp float-right">${message.data.formatted_time_updated}</span>
                    </div>
                    <img class="direct-chat-img" src="{{ asset("assets/logo36.png") }}" alt="message user image">
                    <div class="direct-chat-text bg-gray-dark">`;
        if(message.data.message === "" || message.data.message === null || message.data.message === undefined) {
            html += `${message.data.message}</div>
            </div>`;
        }else {
            html += `<p class="text-danger">No response</p></div>
            </div>`;
        }

        $("#messageViewer").append(html);
        $('html, body').animate({ scrollTop: $(document).height() }, 'fast');
    }
</script>
