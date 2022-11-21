function get_date(year, month, day) {
    return new Date(year, month - 1, day).getTime();
}

function init_flot_chart_cu_management() {
    if (typeof ($.plot) === 'undefined') {
        return;
    }
    
    var arr_data_member_growth = [
        [get_date(2019, 1, 1), 27],
        [get_date(2019, 2, 2), 34],
        [get_date(2019, 3, 3), 62],
        [get_date(2019, 4, 4), 122],
        [get_date(2019, 5, 5), 101],
        [get_date(2019, 6, 6), 54],
        [get_date(2019, 7, 7), 101],
        [get_date(2019, 8, 8), 43],
        [get_date(2019, 9, 9), 131],
        [get_date(2019, 10, 10), 82],
        [get_date(2019, 11, 11), 142],
        [get_date(2019, 12, 12), 144]
    ];

    var chart_plot_saving_data = [
        [get_date(2019, 1, 1), 424250000],
        [get_date(2019, 2, 2), 356500000],
        [get_date(2019, 3, 3), 532300000],
        [get_date(2019, 4, 4), 246700000],
//        [get_date(2019, 5, 5), 484500000],
//        [get_date(2019, 6, 6), 375000000]
    ];

    var chart_plot_loan_data = [
        [get_date(2019, 1, 1), 364000000],
        [get_date(2019, 2, 2), 513500000],
        [get_date(2019, 3, 3), 215200000],
        [get_date(2019, 4, 4), 260500000],
//        [get_date(2019, 5, 5), 460300000],
//        [get_date(2019, 6, 6), 616000000]
    ];

    var chart_plot_member_growth_settings = {
        series: {
            lines: {
                show: false,
                fill: true
            },
            splines: {
                show: true,
                tension: 0.4,
                lineWidth: 3,
                fill: 0.4
            },
            points: {
                radius: 0,
                show: true
            },
            shadowSize: 2
        },
        grid: {
            verticalLines: true,
            hoverable: true,
            clickable: true,
            tickColor: "#d5d5d5",
            borderWidth: 1,
            color: '#fff'
        },
        colors: ["rgba(38, 185, 154, 0.28)", "rgba(3, 88, 106, 0.28)", "rgba(186, 186, 186, 0.18)"],
        xaxis: {
            tickColor: "rgba(51, 51, 51, 0.06)",
            mode: "time",
            tickSize: [1, "month"],
            //tickLength: 10,
            axisLabel: "Month",
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Verdana, Arial',
            axisLabelPadding: 10
        },
        yaxis: {
            ticks: 8,
            tickColor: "rgba(51, 51, 51, 0.06)",
        },
        tooltip: true
    }

    var chart_plot_saving_settings = {
        grid: {
            show: true,
            aboveData: true,
            color: "#3f3f3f",
            labelMargin: 10,
            axisMargin: 0,
            borderWidth: 0,
            borderColor: null,
            minBorderMargin: 5,
            clickable: true,
            hoverable: true,
            autoHighlight: true,
            mouseActiveRadius: 100
        },
        series: {
            lines: {
                show: true,
                fill: true,
                lineWidth: 2,
                steps: false
            },
            points: {
                show: true,
                radius: 4.5,
                symbol: "circle",
                lineWidth: 3.0
            }
        },
        legend: {
            position: "ne",
            margin: [0, -25],
            noColumns: 0,
            labelBoxBorderColor: null,
            labelFormatter: function (label, series) {
                return label + '&nbsp;&nbsp;';
            },
            width: 40,
            height: 1
        },
        colors: ['#96CA59', '#3F97EB', '#72c380', '#6f7a8a', '#f7cb38', '#5a8022', '#2c7282'],
        shadowSize: 0,
        tooltip: true,
        tooltipOpts: {
            content: "%s: %y.0",
            xDateFormat: "%m %y",
            shifts: {
                x: -30,
                y: -50
            },
            defaultTheme: false
        },
        yaxis: {
            min: 0
        },
        xaxis: {
            mode: "time",
            minTickSize: [1, "month"],
            timeformat: "%m"
        }
    };

    var chart_plot_loan_settings = {
        grid: {
            show: true,
            aboveData: true,
            color: "#3f3f3f",
            labelMargin: 10,
            axisMargin: 0,
            borderWidth: 0,
            borderColor: null,
            minBorderMargin: 5,
            clickable: true,
            hoverable: true,
            autoHighlight: true,
            mouseActiveRadius: 100
        },
        series: {
            lines: {
                show: true,
                fill: true,
                lineWidth: 2,
                steps: false
            },
            points: {
                show: true,
                radius: 4.5,
                symbol: "circle",
                lineWidth: 3.0
            }
        },
        legend: {
            position: "ne",
            margin: [0, -25],
            noColumns: 0,
            labelBoxBorderColor: null,
            labelFormatter: function (label, series) {
                return label + '&nbsp;&nbsp;';
            },
            width: 40,
            height: 1
        },
        colors: ['#96CA59', '#3F97EB', '#72c380', '#6f7a8a', '#f7cb38', '#5a8022', '#2c7282'],
        shadowSize: 0,
        tooltip: true,
        tooltipOpts: {
            content: "%s: %y.0",
            xDateFormat: "%m %y",
            shifts: {
                x: -30,
                y: -50
            },
            defaultTheme: false
        },
        yaxis: {
            min: 0
        },
        xaxis: {
            mode: "time",
            minTickSize: [1, "month"],
            timeformat: "%m"
        }
    };


    if ($("#chart_plot_member_growth").length) {
        $.plot($("#chart_plot_member_growth"), [arr_data_member_growth], chart_plot_member_growth_settings);
    }

    if ($("#chart_plot_saving").length) {
        $.plot($("#chart_plot_saving"),
        [{
            data: chart_plot_saving_data,
            lines: {
                fillColor: "rgba(150, 202, 89, 0.12)"
            },
            points: {
                fillColor: "#fff"}
        }], chart_plot_saving_settings);
    }

    if ($("#chart_plot_loan").length) {
        $.plot($("#chart_plot_loan"),
        [{
            data: chart_plot_loan_data,
            lines: {
                fillColor: "rgba(150, 202, 89, 0.12)"
            },
            points: {
                fillColor: "#fff"}
        }], chart_plot_loan_settings);

    }
}

function init_chart_doughnut_cu_management() {
    if (typeof (Chart) === 'undefined') {
        return;
    }

    if ($('.canvasDoughnut_top_product_saving').length) {
        var chart_doughnut_top_product_saving_settings = {
            type: 'doughnut',
            tooltipFillColor: "rgba(51, 51, 51, 0.55)",
            data: {
//                labels: ["SiKOMAS", "SiBERMAS", "SiRADIK", "SiPEMA", "SiPARI"],
                labels: ["SIRAYA", "SIDIDIK", "SIARUM", "SIKOBHAR"],
                datasets: [{
//                    data: [55, 35, 100, 130, 145],
                    data: [55, 35, 100, 130],
                    backgroundColor: ["#BDC3C7", "#9B59B6", "#E74C3C", "#26B99A", "#3498DB"],
                    hoverBackgroundColor: ["#CFD4D8", "#B370CF", "#E95E4F", "#36CAAB", "#49A9EA"]
                }]
            },
            options: {
                legend: false,
                responsive: false
            }
        }

        $('.canvasDoughnut_top_product_saving').each(function () {
            var chart_element_top_product_saving = $(this);
            var chart_doughnut_top_product_saving = new Chart(chart_element_top_product_saving, chart_doughnut_top_product_saving_settings);
        });
    }
    
    if ($('.canvasDoughnut_top_product_loan').length) {
        var chart_doughnut_settings_top_product_loan = {
            type: 'doughnut',
            tooltipFillColor: "rgba(51, 51, 51, 0.55)",
            data: {
//                labels: ["PUNDI", "Modal Kerja", "Investasi", "Konsumtif", "Pendidikan"],
                labels: ["PIJAR", "PINDIK", "PINDARA", "KPRS"],
                datasets: [{
//                    data: [55, 35, 100, 130, 145],
                    data: [55, 35, 100, 130],
                    backgroundColor: ["#26B99A", "#9B59B6", "#E74C3C", "#BDC3C7", "#3498DB"],
                    hoverBackgroundColor: ["#36CAAB", "#B370CF", "#E95E4F", "#CFD4D8", "#49A9EA"]
                }]
            },
            options: {
                legend: false,
                responsive: false
            }
        }

        $('.canvasDoughnut_top_product_loan').each(function () {
            var chart_element_top_product_loan = $(this);
            var chart_doughnut_top_product_loan = new Chart(chart_element_top_product_loan, chart_doughnut_settings_top_product_loan);
        });
    }
    
    if ($('.canvasDoughnut_member_per_unit').length) {
        var chart_doughnut_settings_member_per_unit = {
            type: 'doughnut',
            tooltipFillColor: "rgba(51, 51, 51, 0.55)",
            data: {
//                labels: ["Temon", "Mobile", "Lowanu", "Wirobrajan", "Sanata Dharma"],
                labels: ["TP Tutur", "TP Patimura", "TP Kalasan"],
                datasets: [{
//                    data: [1309, 745, 6101, 1755, 1960],
                    data: [1309, 745, 6101],
                    backgroundColor: ["#26B99A", "#9B59B6", "#E74C3C", "#BDC3C7", "#3498DB"],
                    hoverBackgroundColor: ["#36CAAB", "#B370CF", "#E95E4F", "#CFD4D8", "#49A9EA"]
                }]
            },
            options: {
                legend: false,
                responsive: false
            }
        }

        $('.canvasDoughnut_member_per_unit').each(function () {
            var chart_element_member_per_unit = $(this);
            var chart_doughnut_member_per_unit = new Chart(chart_element_member_per_unit, chart_doughnut_settings_member_per_unit);
        });
    }
}

$(document).ready(function () {
    init_flot_chart_cu_management();
    init_chart_doughnut_cu_management();
});


