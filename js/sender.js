/*  sender.php view js file*/


function request_generate_rsa_key()
{
    $.post(
       '/sender/ajax_generate_keys',
        function(data)
        {
            logger.log(data);
            logger.scrolldown();
        }
    );
}

function request_send_xml()
{
    $.post(
        '/sender/ajax_send_xml',
        function(data)
        {
            logger.log(data);
            logger.scrolldown();
        }
    );
}


var logger =
{
    logger_div_id : 'log',

    log : function(str)
    {
        $('#' + this.logger_div_id).append(str + '<br />');
    },
    clear : function()
    {
        $('#' + this.logger_div_id).html('');
    },
    scrolldown: function()
    {
        $('#' + this.logger_div_id).scrollTop(10000);
    }
}


