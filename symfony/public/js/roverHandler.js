$(document).ready(function () {
    $(".startButton").click(function (event) {
        $('.collision').hide();
        event.preventDefault();
        if ($("form").valid()) {
            $.ajax({
                url: '/execute',
                type: "POST",
                dataType: "json",
                data: {
                    "scenario": {
                        "direction": $('#scenario_roverDirection option:selected').val(),
                        "position": {
                            "x": $('input#scenario_roverPosition_x').val(),
                            "y": $('input#scenario_roverPosition_y').val(),
                        },
                        "size": $('input#scenario_planetSize').val(),
                        "obstacles": $('input#scenario_planetObstacles').val(),
                        "commands": $('input#scenario_commands').val(),
                    }
                },
                async: true,
                success: function (data) {
                    if (data.success) {
                        $('.result-block').css("background", "#8cbf8c");
                    } else {
                        $('.result-block').css("background", "#ff0018cf");
                        if(data.collided) {
                            $('.collision').show();
                        }
                    }
                    $('#result').html(
                        data.message +
                        '<br>' +
                        'Final position: (' + data.roverPosition + ')'
                    );
                }
            });
        }
    });
});