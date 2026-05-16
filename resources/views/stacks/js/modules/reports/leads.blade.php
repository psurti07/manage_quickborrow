<script type="text/javascript">
    $(document).ready(function () {
        var ctx = $("#column-chart");

        var chartOptions = {
            elements: {
                rectangle: {
                    borderWidth: 2,
                    borderColor: '#0e5281',
                    borderSkipped: 'bottom'
                }
            },
            responsive: true,
            maintainAspectRatio: false,
            responsiveAnimationDuration: 500,
            legend: {
                position: 'top',
            },
            scales: {
                xAxes: [{
                    display: true,
                    gridLines: {
                        color: "#f3f3f3",
                        drawTicks: false,
                    },
                    scaleLabel: {
                        display: true,
                    }
                }],
                yAxes: [{
                    display: true,
                    gridLines: {
                        color: "#f3f3f3",
                        drawTicks: false,
                    },
                    scaleLabel: {
                        display: true,
                    }
                }]
            },
        };

        // Chart Data
        var chartData = {
            labels: [{!! $barlabel !!}],
            datasets: [{
                label: "Total Leads",
                data: [{!! $bardata !!}],
                backgroundColor: "#0e5281",
                hoverBackgroundColor: "#1f81c7",
                borderColor: "transparent"
            }]
        };

        var config = {
            type: 'bar',
            options: chartOptions,
            data: chartData
        };

        var lineChart = new Chart(ctx, config);

        $('.modal_data').on('click', function () {
            reset_modal_data();
            var month_name = $(this).attr('data-id');
            let month = $(this).attr('data-ids');
            let year = $(this).attr('id');
            if (month) {
                $.ajax({
                    url: '{!! route('manage.reports.customers.leads.datewise',['type'=>$type,'acc_type'=>$acc_type])  !!}',
                    type: 'POST',
                    data: JSON.stringify({ month: month, year: year }),
                    contentType: "application/json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function () {
                        reset_modal_data(); // This will clear the table and show the spinner
                    },
                    success: function (response) {
                        if (response.type === 'SUCCESS') {
                            var raw_data = '';
                            var total_leads = 0;
                            for (i = 0; i < response.data.length; i++) {
                                raw_data += '<tr>';
                                raw_data += '<td>' + response.data[i].recdate + '</td>';
                                raw_data += '<td class="text-right">' + response.data[i].totaluser + '</td>';
                                raw_data += '</tr>';
                                total_leads += parseInt(response.data[i].totaluser);
                            }
                            if (raw_data) {
                                $('#subtotalleads').html(total_leads);
                            }
                            // Hide the spinner and show the data
                            $('#table_data').html(raw_data); // Replace the spinner with the data
                            $('#clickmonthname').html(month_name + ' - ' + year);
                        } else {
                            toastr.error(result.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        // Hide the spinner in case of an error
                        $('#table_data').html('<tr><td colspan="2" class="text-center">Error loading data.</td></tr>');
                        toastr.error('An error occurred while fetching data.');
                    }
                });
            }
        });
    });

    function reset_modal_data() {
        // Clear the table body except for the loading spinner
        $('#table_data').html('<tr id="loading-spinner"><td colspan="2" class="text-center"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></td></tr>');
        $('#clickmonthname').empty();
        $('#subtotalleads').html('0'); // Use .html() instead of .val() for div elements
    }
</script>
