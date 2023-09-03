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
            // reset form
            $(`#messageForm :input[name="message"]`).val("");
            $(`#messageForm :input[name="image"]`).val("")

            // sending message
            appendSpinner()
            sendMessage(formdata);
        });

        // lisening for keydown
        $(`textarea[name="message"]`).on("keydown", e => {
            if(e.keyCode === 13 && e.ctrlKey) {
                $("#messageForm").submit();
            }
        })

    });

    function sendMessage(formdata) {
        $.ajax({
            url: '{{ route('chat.store') }}', // Replace with your API endpoint
            type: 'POST',
            data: formdata,
            contentType: false, // Set to false for FormData
            processData: false, // Set to false for FormData
            success: function(response) {
                // remove spinner
                removeSpinner()

                // displaying received response
                appendResponse(response.data);

                // btn cleanup
                $("#btnSubmit").removeClass('disabled');
                $("#btnSubmit").html(`<i class="far fa-paper-plane"></i>`)

            },
            error: function(error) {
                // remove spinner
                removeSpinner()
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
        let time = moment().format("D MMM h:m:s a")
        let html = `<div class="direct-chat-msg right ml-5">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-timestamp float-left">${time}</span>
                    </div>
                    <img class="direct-chat-img" src="{{ asset("assets/user36.png") }}" alt="message user image">
                    <div class="direct-chat-text bg-gray-dark pl-3 pt-3 pb-3">
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
        let html = `<div class="direct-chat-msg mr-5">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-timestamp float-right">${message.formatted_time_updated}</span>
                    </div>
                    <img class="direct-chat-img" src="{{ asset("assets/logo36.png") }}" alt="message user image">
                    <div class="direct-chat-text bg-gray-dark pl-3 pt-3 pb-3">`;
        if(message.disease !== "" && message.disease !== null && message.disease !== undefined) {
            html += `<p>{{ __("Predicted Disease") }} - <b>${message.disease}</b> (${message.probability}% {{ __("of probability") }})</p>`;
        }
        if(message.response === "" || message.response === null || message.response === undefined) {
            html += `<p class="text-danger">No response</p></div>
            </div>`;
        }else {
            html += `${message.response.replace(/\n/g, "<br />")}</div>
            </div>`;
        }

        $("#messageViewer").append(html);
        $('html, body').animate({ scrollTop: $(document).height() }, 'fast');
    }

    function appendSpinner() {
        let html = `<div class="direct-chat-msg" id="spinnerDiv">
                    <img class="direct-chat-img" src="{{ asset("assets/logo36.png") }}" alt="message user image">
                    <div class="direct-chat-text bg-gray-dark text-center">
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                </div>`;
        $("#messageViewer").append(html);
        $('html, body').animate({ scrollTop: $(document).height() }, 'fast');
    }

    function removeSpinner() {
        $("#spinnerDiv").remove();
        $('html, body').animate({ scrollTop: $(document).height() }, 'fast');
    }
</script>
