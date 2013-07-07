<div class="container">

<h1>Encoder&Sender script</h1>

<p>Choose one of following</p>
<input type="button" id="generate_rsa" class="btn btn-primary" value="Generate RSA keys"/>
<input type="button" id="send_xml" class="btn btn-primary" value="Generate & Send XML"/>
<br />

<br />
<div id="log" style="border: 1px solid; height: 300px;"></div>
<div id="loading_div"></div>


</div>

<script>
    $(document).ready(
        function()
        {
            $('#generate_rsa').click(request_generate_rsa_key);
            $('#send_xml').click(request_send_xml);
            $(document)
                .ajaxStart(function() {
                    $('#loading_div').show();
                })
                .ajaxStop(function() {
                    $('#loading_div').hide();
                })
            ;
        }
    );
</script>