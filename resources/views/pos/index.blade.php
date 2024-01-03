
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="icon" id="favicon" href="../images/16071590237441.webp" sizes="32x16">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('pos/style.css')}}">
    <!-- <link href="assets/2.97fd0627.chunk.css" rel="stylesheet"> -->
    <!-- <link href="assets/main.e1af72b3.chunk.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">

    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.5/dist/sweetalert2.min.css" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style type="text/css">

        @foreach($lib_categories as $key => $category)
            {{ ".".str_replace(' ','_',$category).$key."{ display: block;}" }}
        @endforeach


    </style>

    <style type="text/css">
        .apexcharts-canvas {
            position: relative;
            user-select: none;
            /* cannot give overflow: hidden as it will crop tooltips which overflow outside chart area */
        }


        /* scrollbar is not visible by default for legend, hence forcing the visibility */
        .apexcharts-canvas ::-webkit-scrollbar {
            -webkit-appearance: none;
            width: 6px;
        }

        .apexcharts-canvas ::-webkit-scrollbar-thumb {
            border-radius: 4px;
            background-color: rgba(0, 0, 0, .5);
            box-shadow: 0 0 1px rgba(255, 255, 255, .5);
            -webkit-box-shadow: 0 0 1px rgba(255, 255, 255, .5);
        }


        .apexcharts-inner {
            position: relative;
        }

        .apexcharts-text tspan {
            font-family: inherit;
        }

        .legend-mouseover-inactive {
            transition: 0.15s ease all;
            opacity: 0.20;
        }

        .apexcharts-series-collapsed {
            opacity: 0;
        }

        .apexcharts-tooltip {
            border-radius: 5px;
            box-shadow: 2px 2px 6px -4px #999;
            cursor: default;
            font-size: 14px;
            left: 62px;
            opacity: 0;
            pointer-events: none;
            position: absolute;
            top: 20px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            white-space: nowrap;
            z-index: 12;
            transition: 0.15s ease all;
        }

        .apexcharts-tooltip.apexcharts-active {
            opacity: 1;
            transition: 0.15s ease all;
        }

        .apexcharts-tooltip.apexcharts-theme-light {
            border: 1px solid #e3e3e3;
            background: rgba(255, 255, 255, 0.96);
        }

        .apexcharts-tooltip.apexcharts-theme-dark {
            color: #fff;
            background: rgba(30, 30, 30, 0.8);
        }

        .apexcharts-tooltip * {
            font-family: inherit;
        }


        .apexcharts-tooltip-title {
            padding: 6px;
            font-size: 15px;
            margin-bottom: 4px;
        }

        .apexcharts-tooltip.apexcharts-theme-light .apexcharts-tooltip-title {
            background: #ECEFF1;
            border-bottom: 1px solid #ddd;
        }

        .apexcharts-tooltip.apexcharts-theme-dark .apexcharts-tooltip-title {
            background: rgba(0, 0, 0, 0.7);
            border-bottom: 1px solid #333;
        }

        .apexcharts-tooltip-text-value,
        .apexcharts-tooltip-text-z-value {
            display: inline-block;
            font-weight: 600;
            margin-left: 5px;
        }

        .apexcharts-tooltip-text-z-label:empty,
        .apexcharts-tooltip-text-z-value:empty {
            display: none;
        }

        .apexcharts-tooltip-text-value,
        .apexcharts-tooltip-text-z-value {
            font-weight: 600;
        }

        .apexcharts-tooltip-marker {
            width: 12px;
            height: 12px;
            position: relative;
            top: 0px;
            margin-right: 10px;
            border-radius: 50%;
        }

        .apexcharts-tooltip-series-group {
            padding: 0 10px;
            display: none;
            text-align: left;
            justify-content: left;
            align-items: center;
        }

        .apexcharts-tooltip-series-group.apexcharts-active .apexcharts-tooltip-marker {
            opacity: 1;
        }

        .apexcharts-tooltip-series-group.apexcharts-active,
        .apexcharts-tooltip-series-group:last-child {
            padding-bottom: 4px;
        }

        .apexcharts-tooltip-series-group-hidden {
            opacity: 0;
            height: 0;
            line-height: 0;
            padding: 0 !important;
        }

        .apexcharts-tooltip-y-group {
            padding: 6px 0 5px;
        }

        .apexcharts-tooltip-candlestick {
            padding: 4px 8px;
        }

        .apexcharts-tooltip-candlestick>div {
            margin: 4px 0;
        }

        .apexcharts-tooltip-candlestick span.value {
            font-weight: bold;
        }

        .apexcharts-tooltip-rangebar {
            padding: 5px 8px;
        }

        .apexcharts-tooltip-rangebar .category {
            font-weight: 600;
            color: #777;
        }

        .apexcharts-tooltip-rangebar .series-name {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .apexcharts-xaxistooltip {
            opacity: 0;
            padding: 9px 10px;
            pointer-events: none;
            color: #373d3f;
            font-size: 13px;
            text-align: center;
            border-radius: 2px;
            position: absolute;
            z-index: 10;
            background: #ECEFF1;
            border: 1px solid #90A4AE;
            transition: 0.15s ease all;
        }

        .apexcharts-xaxistooltip.apexcharts-theme-dark {
            background: rgba(0, 0, 0, 0.7);
            border: 1px solid rgba(0, 0, 0, 0.5);
            color: #fff;
        }

        .apexcharts-xaxistooltip:after,
        .apexcharts-xaxistooltip:before {
            left: 50%;
            border: solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
        }

        .apexcharts-xaxistooltip:after {
            border-color: rgba(236, 239, 241, 0);
            border-width: 6px;
            margin-left: -6px;
        }

        .apexcharts-xaxistooltip:before {
            border-color: rgba(144, 164, 174, 0);
            border-width: 7px;
            margin-left: -7px;
        }

        .apexcharts-xaxistooltip-bottom:after,
        .apexcharts-xaxistooltip-bottom:before {
            bottom: 100%;
        }

        .apexcharts-xaxistooltip-top:after,
        .apexcharts-xaxistooltip-top:before {
            top: 100%;
        }

        .apexcharts-xaxistooltip-bottom:after {
            border-bottom-color: #ECEFF1;
        }

        .apexcharts-xaxistooltip-bottom:before {
            border-bottom-color: #90A4AE;
        }

        .apexcharts-xaxistooltip-bottom.apexcharts-theme-dark:after {
            border-bottom-color: rgba(0, 0, 0, 0.5);
        }

        .apexcharts-xaxistooltip-bottom.apexcharts-theme-dark:before {
            border-bottom-color: rgba(0, 0, 0, 0.5);
        }

        .apexcharts-xaxistooltip-top:after {
            border-top-color: #ECEFF1
        }

        .apexcharts-xaxistooltip-top:before {
            border-top-color: #90A4AE;
        }

        .apexcharts-xaxistooltip-top.apexcharts-theme-dark:after {
            border-top-color: rgba(0, 0, 0, 0.5);
        }

        .apexcharts-xaxistooltip-top.apexcharts-theme-dark:before {
            border-top-color: rgba(0, 0, 0, 0.5);
        }

        .apexcharts-xaxistooltip.apexcharts-active {
            opacity: 1;
            transition: 0.15s ease all;
        }

        .apexcharts-yaxistooltip {
            opacity: 0;
            padding: 4px 10px;
            pointer-events: none;
            color: #373d3f;
            font-size: 13px;
            text-align: center;
            border-radius: 2px;
            position: absolute;
            z-index: 10;
            background: #ECEFF1;
            border: 1px solid #90A4AE;
        }

        .apexcharts-yaxistooltip.apexcharts-theme-dark {
            background: rgba(0, 0, 0, 0.7);
            border: 1px solid rgba(0, 0, 0, 0.5);
            color: #fff;
        }

        .apexcharts-yaxistooltip:after,
        .apexcharts-yaxistooltip:before {
            top: 50%;
            border: solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
        }

        .apexcharts-yaxistooltip:after {
            border-color: rgba(236, 239, 241, 0);
            border-width: 6px;
            margin-top: -6px;
        }

        .apexcharts-yaxistooltip:before {
            border-color: rgba(144, 164, 174, 0);
            border-width: 7px;
            margin-top: -7px;
        }

        .apexcharts-yaxistooltip-left:after,
        .apexcharts-yaxistooltip-left:before {
            left: 100%;
        }

        .apexcharts-yaxistooltip-right:after,
        .apexcharts-yaxistooltip-right:before {
            right: 100%;
        }

        .apexcharts-yaxistooltip-left:after {
            border-left-color: #ECEFF1;
        }

        .apexcharts-yaxistooltip-left:before {
            border-left-color: #90A4AE;
        }

        .apexcharts-yaxistooltip-left.apexcharts-theme-dark:after {
            border-left-color: rgba(0, 0, 0, 0.5);
        }

        .apexcharts-yaxistooltip-left.apexcharts-theme-dark:before {
            border-left-color: rgba(0, 0, 0, 0.5);
        }

        .apexcharts-yaxistooltip-right:after {
            border-right-color: #ECEFF1;
        }

        .apexcharts-yaxistooltip-right:before {
            border-right-color: #90A4AE;
        }

        .apexcharts-yaxistooltip-right.apexcharts-theme-dark:after {
            border-right-color: rgba(0, 0, 0, 0.5);
        }

        .apexcharts-yaxistooltip-right.apexcharts-theme-dark:before {
            border-right-color: rgba(0, 0, 0, 0.5);
        }

        .apexcharts-yaxistooltip.apexcharts-active {
            opacity: 1;
        }

        .apexcharts-yaxistooltip-hidden {
            display: none;
        }

        .apexcharts-xcrosshairs,
        .apexcharts-ycrosshairs {
            pointer-events: none;
            opacity: 0;
            transition: 0.15s ease all;
        }

        .apexcharts-xcrosshairs.apexcharts-active,
        .apexcharts-ycrosshairs.apexcharts-active {
            opacity: 1;
            transition: 0.15s ease all;
        }

        .apexcharts-ycrosshairs-hidden {
            opacity: 0;
        }

        .apexcharts-selection-rect {
            cursor: move;
        }

        .svg_select_boundingRect,
        .svg_select_points_rot {
            pointer-events: none;
            opacity: 0;
            visibility: hidden;
        }

        .apexcharts-selection-rect+g .svg_select_boundingRect,
        .apexcharts-selection-rect+g .svg_select_points_rot {
            opacity: 0;
            visibility: hidden;
        }

        .apexcharts-selection-rect+g .svg_select_points_l,
        .apexcharts-selection-rect+g .svg_select_points_r {
            cursor: ew-resize;
            opacity: 1;
            visibility: visible;
        }

        .svg_select_points {
            fill: #efefef;
            stroke: #333;
        }

        .apexcharts-svg.apexcharts-zoomable.hovering-zoom {
            cursor: crosshair
        }

        .apexcharts-svg.apexcharts-zoomable.hovering-pan {
            cursor: move
        }

        .apexcharts-zoom-icon,
        .apexcharts-zoomin-icon,
        .apexcharts-zoomout-icon,
        .apexcharts-reset-icon,
        .apexcharts-pan-icon,
        .apexcharts-selection-icon,
        .apexcharts-menu-icon,
        .apexcharts-toolbar-custom-icon {
            cursor: pointer;
            width: 20px;
            height: 20px;
            line-height: 24px;
            color: #6E8192;
            text-align: center;
        }

        .apexcharts-zoom-icon svg,
        .apexcharts-zoomin-icon svg,
        .apexcharts-zoomout-icon svg,
        .apexcharts-reset-icon svg,
        .apexcharts-menu-icon svg {
            fill: #6E8192;
        }

        .apexcharts-selection-icon svg {
            fill: #444;
            transform: scale(0.76)
        }

        .apexcharts-theme-dark .apexcharts-zoom-icon svg,
        .apexcharts-theme-dark .apexcharts-zoomin-icon svg,
        .apexcharts-theme-dark .apexcharts-zoomout-icon svg,
        .apexcharts-theme-dark .apexcharts-reset-icon svg,
        .apexcharts-theme-dark .apexcharts-pan-icon svg,
        .apexcharts-theme-dark .apexcharts-selection-icon svg,
        .apexcharts-theme-dark .apexcharts-menu-icon svg,
        .apexcharts-theme-dark .apexcharts-toolbar-custom-icon svg {
            fill: #f3f4f5;
        }

        .apexcharts-canvas .apexcharts-zoom-icon.apexcharts-selected svg,
        .apexcharts-canvas .apexcharts-selection-icon.apexcharts-selected svg,
        .apexcharts-canvas .apexcharts-reset-zoom-icon.apexcharts-selected svg {
            fill: #008FFB;
        }

        .apexcharts-theme-light .apexcharts-selection-icon:not(.apexcharts-selected):hover svg,
        .apexcharts-theme-light .apexcharts-zoom-icon:not(.apexcharts-selected):hover svg,
        .apexcharts-theme-light .apexcharts-zoomin-icon:hover svg,
        .apexcharts-theme-light .apexcharts-zoomout-icon:hover svg,
        .apexcharts-theme-light .apexcharts-reset-icon:hover svg,
        .apexcharts-theme-light .apexcharts-menu-icon:hover svg {
            fill: #333;
        }

        .apexcharts-selection-icon,
        .apexcharts-menu-icon {
            position: relative;
        }

        .apexcharts-reset-icon {
            margin-left: 5px;
        }

        .apexcharts-zoom-icon,
        .apexcharts-reset-icon,
        .apexcharts-menu-icon {
            transform: scale(0.85);
        }

        .apexcharts-zoomin-icon,
        .apexcharts-zoomout-icon {
            transform: scale(0.7)
        }

        .apexcharts-zoomout-icon {
            margin-right: 3px;
        }

        .apexcharts-pan-icon {
            transform: scale(0.62);
            position: relative;
            left: 1px;
            top: 0px;
        }

        .apexcharts-pan-icon svg {
            fill: #fff;
            stroke: #6E8192;
            stroke-width: 2;
        }

        .apexcharts-pan-icon.apexcharts-selected svg {
            stroke: #008FFB;
        }

        .apexcharts-pan-icon:not(.apexcharts-selected):hover svg {
            stroke: #333;
        }

        .apexcharts-toolbar {
            position: absolute;
            z-index: 11;
            max-width: 176px;
            text-align: right;
            border-radius: 3px;
            padding: 0px 6px 2px 6px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .apexcharts-menu {
            background: #fff;
            position: absolute;
            top: 100%;
            border: 1px solid #ddd;
            border-radius: 3px;
            padding: 3px;
            right: 10px;
            opacity: 0;
            min-width: 110px;
            transition: 0.15s ease all;
            pointer-events: none;
        }

        .apexcharts-menu.apexcharts-menu-open {
            opacity: 1;
            pointer-events: all;
            transition: 0.15s ease all;
        }

        .apexcharts-menu-item {
            padding: 6px 7px;
            font-size: 12px;
            cursor: pointer;
        }

        .apexcharts-theme-light .apexcharts-menu-item:hover {
            background: #eee;
        }

        .apexcharts-theme-dark .apexcharts-menu {
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
        }

        @media screen and (min-width: 768px) {
            .apexcharts-canvas:hover .apexcharts-toolbar {
                opacity: 1;
            }
        }

        .apexcharts-datalabel.apexcharts-element-hidden {
            opacity: 0;
        }

        .apexcharts-pie-label,
        .apexcharts-datalabels,
        .apexcharts-datalabel,
        .apexcharts-datalabel-label,
        .apexcharts-datalabel-value {
            cursor: default;
            pointer-events: none;
        }

        .apexcharts-pie-label-delay {
            opacity: 0;
            animation-name: opaque;
            animation-duration: 0.3s;
            animation-fill-mode: forwards;
            animation-timing-function: ease;
        }

        .apexcharts-canvas .apexcharts-element-hidden {
            opacity: 0;
        }

        .apexcharts-hide .apexcharts-series-points {
            opacity: 0;
        }

        .apexcharts-gridline,
        .apexcharts-annotation-rect,
        .apexcharts-tooltip .apexcharts-marker,
        .apexcharts-area-series .apexcharts-area,
        .apexcharts-line,
        .apexcharts-zoom-rect,
        .apexcharts-toolbar svg,
        .apexcharts-area-series .apexcharts-series-markers .apexcharts-marker.no-pointer-events,
        .apexcharts-line-series .apexcharts-series-markers .apexcharts-marker.no-pointer-events,
        .apexcharts-radar-series path,
        .apexcharts-radar-series polygon {
            pointer-events: none;
        }


        /* markers */

        .apexcharts-marker {
            transition: 0.15s ease all;
        }

        @keyframes opaque {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }


        /* Resize generated styles */

        @keyframes resizeanim {
            from {
                opacity: 0;
            }

            to {
                opacity: 0;
            }
        }

        .resize-triggers {
            animation: 1ms resizeanim;
            visibility: hidden;
            opacity: 0;
        }

        .resize-triggers,
        .resize-triggers>div,
        .contract-trigger:before {
            content: " ";
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            overflow: hidden;
        }

        .resize-triggers>div {
            background: #eee;
            overflow: auto;
        }

        .contract-trigger:before {
            width: 200%;
            height: 200%;
        }

        @media screen and (min-width: 768px) {
            .noticeForMobilePos {
                display: none;
            }
        }
    </style>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }


        .styled-checkbox {
            /* position: absolute; */
            opacity: 0;
        }

        .styled-checkbox+label {
            position: relative;
            cursor: pointer;
            padding: 0;
        }

        .styled-checkbox+label:before {
            content: "";
            margin-right: 10px;
            display: inline-block;
            vertical-align: text-top;
            width: 30px;
            height: 30px;
            background: grey;
        }

        .styled-checkbox:hover+label:before {
            background: #f35429;
        }

        .styled-checkbox:focus+label:before {
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.12);
        }

        .styled-checkbox:checked+label:before {
            background: #f35429;
        }

        .styled-checkbox:disabled+label {
            color: #b8b8b8;
            cursor: auto;
        }

        .styled-checkbox:disabled+label:before {
            box-shadow: none;
            background: #ddd;
        }

        .styled-checkbox:checked+label:after {
            content: "";
            position: absolute;
            left: 5px;
            top: 9px;
            background: white;
            width: 4px;
            height: 4px;
            box-shadow: 2px 0 0 white, 4px 0 0 white, 4px -2px 0 white, 4px -4px 0 white, 4px -6px 0 white, 4px -8px 0 white;
            transform: rotate(50deg);
        }

        .unstyled {
            margin: 0;
            padding: 0;
            list-style-type: none;
        }

        li {
            margin: 20px 0;
        }

        .centered {
            width: 300px;
            margin-left: 5px;
            text-align: left;
        }

        .title {
            text-align: center;
            color: #4571ec;
        }

        /* Increment and Decrement */

        .quantity {
            display: flex;
            align-items: center;
            margin-left: 8%;
            /* padding: 0; */
        }

        .quantity__minus,
        .quantity__plus {
            display: block;
            width: 70px;
            height: 70px;
            /* margin: 0; */
            background: #ffa259;
            text-decoration: none;
            text-align: center;
            line-height: 70px;
            font-size: 30px;
            border: 3px solid #ffa259;
        }

        .quantity__minus:hover,
        .quantity__plus:hover {
            background: #ffa697;
            color: #000000;
        }

        .quantity__minus {
            border-radius: 4px 0 0 4px;
        }

        .quantity__plus {
            border-radius: 0px 4px 4px 0px;
        }

        .quantity__input {
            width: 130px;
            height: 70px;
            /* margin: 0;
            padding: 0; */
            text-align: center;
            border-top: 3px solid #ffa259;
            border-bottom: 3px solid #ffa259;
            background: transparent;
            color: #2c2c2f;
            font-size: 22px;
        }

        .quantity__minus:link,
        .quantity__plus:link {
            color: #232323;
        }

        .quantity__minus:visited,
        .quantity__plus:visited {
            color: #fff;
        }

        .ul-table {
            max-width: 100%;
            /* background-color: yellow; */
            max-height: 500px;
            overflow-x: scroll;
            overflow-y: scroll;
        }

        .li-table {
            border: 1px solid #000000;
            padding: 6px 5px;
            display: inline-grid;
        }

        .optionsClass {
            display: inline-block;
            padding: 4px;
            margin: 2px;
            border: 1px solid black;
            background-color: rgba(255, 255, 255, .7);
        }

        .finishingButtons {
            height: 55px;
        }

        .scrollable-div {
            width: 100%;
            max-height: 200px;
            overflow-y: auto;
        }
        .fk-dish-card__img {
            width: 100%;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            overflow: hidden;
            background: #dee2e6;
                background-color: rgb(222, 226, 230);
            border-radius: 20px;
        }

        /* FOR SELECT2 */
        .select2-container--default .select2-selection--single {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: justify;
            -ms-flex-pack: justify;
            justify-content: space-between;
            padding: 15px 10px;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 0;
            font-size: 12px;
            height: 10px;
        }
        .select2-results__option {
            font-size: 12px;
            color: #374a5e;
        }

        .select2-results__option {
            padding: 4px;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            -webkit-user-select: none;
        }
        li {
            margin: 0px 0px;
            /* padding: 10px; */
        }

        /* END FRO SELECT2 */

        .nav-tabs .nav-link {
            margin-bottom: -1px;
            border: 1px solid transparent;
            border-top-left-radius: 0.25rem;
            border-top-right-radius: 0.25rem;
            background-color: #f9e4d3;
            padding: 1px 5px;
            /* padding: 5px; */
            font-size: 12px;
            margin: 1px;
        }
        .nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {
            color: #495057;
            background-color: #FFA259;
            border-color: #dee2e6 #dee2e6 #fff;
        }
    </style>


    <title>{{ getHostInfo()['name'] }} POS </title>
</head>

<body cz-shortcut-listen="true" class=""><noscript class="">You need to enable JavaScript to run this app.</noscript>

    <div id="kona">

        <div class="Toastify"></div>

        <main id="main" data-simplebar="init">

            {{-- here --}}
            <div class="simplebar-scroll-content" style="padding-right: 17px; margin-bottom: -34px;">
                <div class="simplebar-content" style="padding-bottom: 17px; margin-right: -17px;">

                    <div class="noticeForMobilePos">
                        <h2 class="text-center">Please Take Orders on a Tablet or Desktop in Landscape Mode</h2>
                    </div>



                    <div class="fk-main d-none d-md-block t-mt-10">
                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-5">
                                    <div class="">
                                        <div class="fk-left-over">
                                            <div style="background-color: #fff; padding: 5px 20px;">
                                                <div class="row" style=" margin: 0;">
                                                    <div class="col-12 col-lg-7">
                                                        <h5 style=" margin: 0; padding: 0;">{{ getHostInfo()['name'] }} POS ({{ salesTypes()[$salesType] }})</h5>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="categorySection" >

                                            </div>
                                            <div class="row t-mt-10 gx-2">
                                                <div class="col">
                                                    <input type="hidden" id="productId" value="0" name="productId">
                                                    <input type="hidden" name="tableIdNo" value="0" id="tableIdNo">
                                                    <div class="" id="productSection">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-7">
                                    <div>
                                        <div style="background-color: #fff;" class="pl-3 pt-2 pr-3 pb-1">
                                            <form id="switchFormId" action="{{ route('switch_account') }}" method="post">
                                                @csrf
                                                <div class="d-flex bd-highlight mb-3">
                                                    <div class=" bd-highlight">
                                                        <input type="password" name="employee_id" style="width: 100%; box-sizing: border-box; padding:5px 10px; border:none; border: 1px solid #dee2e6;" placeholder="Pin No">
                                                    </div>
                                                    <div class=" bd-highlight">
                                                        <input onclick="switchFormId.submit();"  type="button" style="background-color: #0dd19d; color: cornsilk; width: 100%; box-sizing: border-box; padding:5px 10px; border:none; border: 1px solid #dee2e6; border-radius:10px" value="Switch Account">
                                                    </div>
                                                    <div class="ml-auto  bd-highlight">
                                                        <div class="d-flex justify-content-center">
                                                            <img src="{{ asset('profiles/'.$user->profile_image) }}" style="height:30px; width:30px; border-radius: 50%;" alt="">
                                                        </div>
                                                        <div class="d-flex justify-content-center">
                                                            <span style="font-size: 10px;">{{ $user->first_name.' '.$user->last_name }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="row mb-3" style="margin-left: 2px;">

                                                <div class="col-3" style="padding:1px;">
                                                    <label for="concern">Concern</label>
                                                    <select class="js-example-basic-single" name="concern" id="concern" onchange="concernWiseAllData(this.value);" disabled>
                                                        <option value="">-- Select --</option>
                                                        @foreach ($companies as $company)
                                                            <option value="{{ $company->id  }}" {{ $company_id == $company->id ? 'selected' : '' }}>{{ $company->Name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-3 d-none" style="padding:1px; padding-left: 10px;">
                                                    <label for="concern">Sales Type</label>
                                                    <select onchange="changeSelseType()" class="js-example-basic-single" name="" id="sales_type" onchange=""  style="height: 20px !important;">
                                                        @foreach (salesTypes() as $key => $type)
                                                            <option value="{{ $key  }}" {{ $key == $salesType ? 'selected' : '' }}>{{ $type }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-3" style="padding:1px;">
                                                    <label for="servedBy">Served By</label>
                                                    <select class="js-example-basic-single" id="servedBy" name="servedBy">
                                                        <option value="">-- Select --</option>
                                                    </select>
                                                </div>
                                                <div class="col-3" style="padding:1px;padding-right:10px;">
                                                    <label for="clientId">Guest</label>
                                                    <div style="background-color: #000;">
                                                        <input type="text" style="text-size: 12px; width: 100%; box-sizing: border-box; padding:3px 10px; border:none; border: 1px solid #dee2e6;" id="selectedCustomerName" class="" data-toggle="modal" data-target="#exampleModal" placeholder="Select Guest" readonly>
                                                        <input type="hidden" id="selectedCustomerId">
                                                        <input type="hidden" id="customerDiscountId">
                                                    </div>
                                                </div>
                                                <div class="col-3" style="padding:1px;padding-right:10px;">
                                                    <label for="dineInPerson">Dine In Person</label>
                                                    <div style="background-color: #000;">
                                                        <input type="text" style="text-size: 12px; width: 100%; box-sizing: border-box; padding:3px 10px; border:none; border: 1px solid #dee2e6;" id="dineInPerson" class="" placeholder="Dine In Person">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="container-fluid " id="tableHolder">

                                            </div>
                                        </div>

                                        <div class="row mt-2">

                                            <div class="col-12 col-xl-5 d-none d-xl-inline" id="productPanal">
                                                <div class="" >
                                                    <div class="tab-content t-mb-10 mb-xl-0">
                                                        <div class="" id="addons-1">
                                                            <div class="t-bg-white">
                                                                <div class="" data-simplebar="init">
                                                                    {{-- fk-addons-variation --}}

                                                                    <div class="simplebar-scroll-content" style="padding-right: 17px; margin-bottom: -34px;">

                                                                        <div class="simplebar-content" style="padding-bottom: 17px; margin-right: -17px;">
                                                                            <div class="fk-addons-table">
                                                                                <div class="d-flex justify-content-end " style="padding-right: 30px; padding-top: 5px;">
                                                                                    <button id="switchId" class="btn btn-sm btn-primary d-xl-none" onclick="switchProductOrList('list')">Close</button>
                                                                                </div>

                                                                                <div style="overflow-y: auto; max-height: 50vh;">
                                                                                    <h3 class="text-center" id="productName" style="margin: 0px;">
                                                                                        Product
                                                                                    </h3>
                                                                                    <div style="display: flex; justify-content: center;">
                                                                                        <img src="" class="img-fluid" id="selectedImg" style="width:50%; height: auto; " alt="">
                                                                                    </div>

                                                                                    <div class="fk-addons-table__head text-center" style="padding: 0px;">
                                                                                        Size
                                                                                    </div>
                                                                                    <div class="fk-addons-table__info py-4">
                                                                                        <div class="row g-0">
                                                                                            <div class="col-12 text-center border-right" id="sizeHolder">

                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="fk-addons-table__head text-center" style="padding: 0px;">
                                                                                        Addons & Options
                                                                                    </div>
                                                                                    <div class="fk-addons-table__info py-4">
                                                                                        <div class="row g-0">
                                                                                            <div class="col-12 text-center border-right" id="optionHolder">



                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="fk-addons-table__info" style="background-color: #fff;">
                                                                                    <div class="text-center border-right">
                                                                                        <div class="quantity quantity m-0 d-flex justify-content-center">
                                                                                            <a href="#" class="quantity__minus" style="border-top-left-radius: 50%; border-bottom-left-radius: 50%; width: 40px; height: 40px; line-height: 30px;" >-</a>
                                                                                            <input name="productQuntity" type="text" class="quantity__input" value="1" id="productQuantity" style="width: 50px; height: 40px;">
                                                                                            <a href="#" class="quantity__plus" style="border-top-right-radius: 50%; border-bottom-right-radius: 50%; width: 40px; height: 40px; line-height: 30px;" >+</a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="fk-addons-table__info" style="background-color: #fff;">
                                                                                    <div class="text-center border-right">
                                                                                        <div class="quantity quantity m-0 d-flex justify-content-center">
                                                                                            <button class=" btn my-3" id="addToListBtn" onclick="addProductForTable();" style="background-color: #0dd19d; color: cornsilk; border-radius: 25px;">
                                                                                                Add To List
                                                                                            </button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-12 col-xl-7 d-xl-inline m-0 p-0" id="listPanal">
                                                <div id="selectedProductList" class="" style="background-color: #fff; padding:20px; margin-right: 30px; overflow-y: auto; height:68vh;">
                                                    <h6>Selected product list.</h6>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>






                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer id="footer" class="sicky-bottom">
            <div class="container-fluid">
                <div class="row align-items-lg-center">
                    <div class="col-lg-2 t-mb- mb-lg-0">
                        <div class="fk-brand--footer fk-brand--footer-sqr mx-auto mr-lg-auto ml-lg-0"><a class="t-link w-100 t-h-50 active" href="#" aria-current="page"><span class="fk-brand--footer-img fk-brand__img--fk" style="background-color: rgb(255, 255, 255); background-image: url(../images/16071590237441.webp);"></span></a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-7 t-mb-0 mb-lg-0">
                        <p class="mb-0 text-center sm-text">© KONA || All rights reserved</p>
                    </div>
                    <div class="col-lg-4 col-xl-3">
                        <div class="clock" style="background-color: rgb(208, 2, 27);">
                            <div class="clock__icon t-mr-30"><span class="far fa-clock" style="color: #000000; "></span>
                            </div>
                            <div class="clock__content">
                                <div id="MyClockDisplay" class="clockDisply" style="color: rgb(255, 255, 255);">Time
                                </div>
                                <p id="datePlaceholder" class="mb-0 font-10px  text-center font-weight-normal" style="color: rgb(255, 255, 255);">Date</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    {{-- Customer modal --}}

    <div class="modal fade "  id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog d-none d-md-block modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Guest</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-end">
                        <button id="addOrSelectBtn" style="border-radius: 2px; color: #fff;background-color: #158df7;border-color: #158df7; height: 20px; font-size: 10px;" onclick="addOrSelect()">Add New</button>
                    </div>

                    <form class="form-inline">
                        <div class="row">
                            <div class="col-5">
                                <label for="search_phone" class="">Phone</label>
                                <input type="text" class="form-control" id="search_phone" placeholder="Phone">
                            </div>
                            <div class="col-5">
                                <label for="search_name" class="">Name</label>
                                <input type="text" class="form-control" id="search_name" placeholder="Name">
                            </div>
                            <div class="col-2">
                                <label for="inputName" class=""></label> <br>
                                <button id="findOrAdd" onclick="findCustomer()" type="button" class="btn btn-success">Find</button>
                            </div>
                        </div>

                    </form> <br>

                    <div class="row" id="customer_list">
                        <div class="col-6" style="padding: 0;">
                            <div  class="">
                                <table class="table" style="margin: 0; padding: 0; font-size: 10px;">
                                    <thead>
                                      <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody id="customer_container">

                                    </tbody>
                                  </table>
                            </div>
                        </div>
                        <div class="col-6 " style="padding: 0;">
                            <div class="container" id="customerProfileContent">


                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- ======= --}}




    {{-- Today's Orders modal --}}

    <div class="modal fade "  id="todaysOrdersModal" tabindex="-1" role="dialog" aria-labelledby="todaysOrdersModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl d-none d-md-block" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="todaysOrdersModalLabel">Today's Orders List</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body" >
                    <div id="accordion">

                        <table class="table" style="">
                            <thead>
                              <tr>
                                @php
                                    $col = 9;
                                @endphp
                                <th scope="col" style="width:{{ 100/$col }}%;">Sales Type</th>
                                <th scope="col" style="width:{{ 100/$col }}%;">Online</th>
                                <th scope="col" style="width:{{ 100/$col }}%;">Table</th>
                                <th scope="col" style="width:{{ 100/$col }}%;">Room</th>
                                <th scope="col" style="width:{{ 100/$col }}%;">Guest</th>
                                <th scope="col" style="width:{{ 100/$col }}%;">Total Bill</th>
                                <th align="right" colspan="3" scope="col" style="width:{{ (100/$col)*3 }}%;">Action</th>
                              </tr>
                            </thead>
                            <tbody id="todaysOrdersListHolder">

                            </tbody>
                        </table>

                    </div>

                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- ======= --}}





    {{-- Address Modal --}}

    <div class="modal fade "  id="addressModal" tabindex="-1" role="dialog" aria-labelledby="addressModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl d-none d-md-block" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="addressModalLabel">Delivery Address</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body" >
                    <form action="" id="addressForm" method="post">
                        <div class="accordion shadow-lg" id="addresslist">

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- ======= --}}


    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="{{asset('pos/bootstrap.bundle.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.5/dist/sweetalert2.min.js"></script>

    <script src="{{asset('common/script.js')}}"></script>


    <!-- <script src="assets/simplebar.js"></script> -->
    <!-- <script src="assets/feather.js"></script> -->
    <!-- <script src="assets/anime-mouse-move.js"></script> -->
    <!-- <script src="assets/main.js"></script> -->
    <script>
        var d = new Date();
        var GBL_IMG_URL = "{{asset('product_images')}}";
        var GBL_ADDRESS_COUNT = 2;
        var orderId = 0;
        document.getElementById("datePlaceholder").innerHTML = d.toDateString();
        $(document).ready(function() {

            var element = document.getElementById('concern');
            var event = new Event('change');
            element.dispatchEvent(event);

            $('.js-example-basic-single').select2();
            document.getElementById("productSection").innerHTML = productPlaceHolder(20);
            document.getElementById("categorySection").innerHTML = categoryPlaceHolder(15);
            getcustomerAddress();
            showTime();

        });

        function showTime() {
            var date = new Date();
            var h = date.getHours(); // 0 - 23
            var m = date.getMinutes(); // 0 - 59
            var s = date.getSeconds(); // 0 - 59
            var session = "AM";

            if (h == 0) {
                h = 12;
            }

            if (h > 12) {
                h = h - 12;
                session = "PM";
            }

            h = h < 10 ? "0" + h : h;
            m = m < 10 ? "0" + m : m;
            s = s < 10 ? "0" + s : s;

            var time = h + ":" + m + ":" + s + " " + session;
            var clockDisplay = $("#MyClockDisplay");
            if (clockDisplay.length) {
                document.getElementById("MyClockDisplay").innerText = time;
                document.getElementById("MyClockDisplay").textContent = time;
            }

            setTimeout(showTime, 1000);
        }
    </script>
    <script>
        function sortProduct(className,ele) {
            var classNamesJS = [
                @foreach ($lib_categories as $key => $category)
                    "{{ str_replace(' ','_',$category).$key }}",
                @endforeach
            ];


            if (className != "All") {
                classNamesJS.forEach(hideAll);
                $("." + className).show("fast", "linear");
            } else {
                classNamesJS.forEach(showAll);
            }

            var elements = document.getElementsByClassName("categoryBtn");

            for(var i=0; i<elements.length; i++){
                elements[i].style.backgroundColor = "#fff";
                elements[i].style.color = "#000";
            }
            ele.style.backgroundColor = "#7367f0";
            ele.style.color = "#fff";
        }

        function clickOntable(ele){
            // alert('ckkk');
            var elements = document.getElementsByClassName("tableBtn");
            for(var i=0; i<elements.length; i++){
                var forAttribute = elements[i].getAttribute('for');
                if(document.getElementById(forAttribute).disabled){continue;}
                elements[i].style.backgroundColor = "#fff";
                elements[i].style.color = "#000";
            }
            ele.style.backgroundColor = "#7367f0";
            ele.style.color = "#fff";
            // console.log(ele);

            switchProductOrList("list");
        }

        function clickOnRoom(ele){
            var elements = document.getElementsByClassName("roomBtn");
            for(var i=0; i<elements.length; i++){
                var forAttribute = elements[i].getAttribute('for');
                if(document.getElementById(forAttribute).disabled){continue;}
                elements[i].style.backgroundColor = "#fff";
                elements[i].style.color = "#000";
            }
            ele.style.backgroundColor = "#7367f0";
            ele.style.color = "#fff";

            switchProductOrList("list");
        }

        function getTablesItem(){
            var concern = document.getElementById("concern").value*1;
            var salesType = document.getElementById("sales_type").value*1;
            var tableOrRoom = document.getElementById("tableOrRoom").value*1;
            if(tableOrRoom == 1){
                var selectedTable = document.querySelector('input[name="tableId"]:checked');
            }
            if(tableOrRoom == 2){
                var selectedTable = document.querySelector('input[name="roomId"]:checked');
            }

            var isDelivered = $("#isDelivered").prop("checked");
            if(!isDelivered && !selectedTable) {
                document.getElementById("selectedProductList").innerHTML = `<h6>Selected product list</b></h6>`;
                return;
            }
            var table = isDelivered ? 0 : selectedTable.value;
            tableOrRoom = isDelivered ? 0 : tableOrRoom;

            waitingSection(true);
            $.get('{{ route('get_table_item_list_by_ajax') }}', {concern:concern,salesType:salesType,tableOrRoom:tableOrRoom,table:table}, function(data){
                // // console.log(concern+" "+salesType+" "+tableOrRoom+" "+table );
                // console.log(data.order);
                document.getElementById("selectedProductList").innerHTML = data.html;

                var order = data.order;
                if(order){

                    $("#selectedCustomerName").val(order.client_name);
                    $("#selectedCustomerId").val(order.client_id);
                    $("#sales_type").val(order.sales_type);
                    if(order.dineIn_place > 0)$("#tableOrRoom").val(order.dineIn_place);
                    $('.js-example-basic-single').select2();

                    if(order.isDelivered == 1){
                        document.getElementById("default_section").classList.add('d-none');
                        document.getElementById("address_section").classList.remove('d-none');
                        document.getElementById("selected_address_temp_id").value = '';
                        document.getElementById("selected_address_id").value = order.delivery_address;
                        document.getElementById("selected_address_label").innerHTML = order.address_label;
                        document.getElementById("selected_address_text").innerHTML = order.local_address;
                        getcustomerAddress();
                    }

                    if(order.discount_category != 0) $("#discountCategory").val(order.discount_category);
                    var ele = document.getElementById("discountCategory");
                    selectDiscountCategory(ele);
                    $("#deliveryCharge").val(order.delivery_charge);
                    discountAndDelivery();
                }

                var discount = document.getElementById("customerDiscountId").value;
                if(discount > 0){
                    var ele = document.getElementById("discountCategory");
                    if(ele){
                        ele.value = discount;
                        selectDiscountCategory(ele);
                        discountAndDelivery();
                        ele.disabled = true;
                    }
                }else{
                    var ele = document.getElementById("discountCategory");
                    if(ele){
                        ele.disabled = false;
                    }
                }

                waitingSection(false);
            });
        }

        function hideAll(item, index) {
            $("." + item).hide("fast", "swing");
        }

        function showAll(item, index) {
            $("." + item).show("fast", "swing");
        }

        async function doneOrder(isUpdate){

            var form = document.getElementById('addressForm');
            var formData = new FormData(form);

            var obj = {};
            for (var pair of formData.entries()) {
                var key = pair[0];
                key = key.replace(/\[|\]/g, '');
                var value = pair[1];
                if (!obj[key]) {obj[key] = [];}
                obj[key].push(value);
            }
            var obj = JSON.stringify(obj);

            if(isUpdate){
                const result = await Swal.fire({
                    title: 'Are you sure?',
                    text: 'Are you sure you want to update the order?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, update it!',
                    cancelButtonText: 'No, cancel!',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                });

                if(!result.isConfirmed){return;}
            }
            var concern = document.getElementById("concern").value*1;
            var salesType = document.getElementById("sales_type").value*1;
            var tableOrRoom = document.getElementById("tableOrRoom").value*1;
            if(tableOrRoom == 1){
                var selectedTable = document.querySelector('input[name="tableId"]:checked');
            }
            if(tableOrRoom == 2){
                var selectedTable = document.querySelector('input[name="roomId"]:checked');
            }
            var isDelivered = $("#isDelivered").prop("checked");
            var table = isDelivered ? 0 : selectedTable.value * 1;
            tableOrRoom = isDelivered ? 0 : tableOrRoom;
            var customer = document.getElementById("selectedCustomerId").value * 1;
            var servedBy = document.getElementById("servedBy").value * 1;
            if(!customer){makeAlert('Select Guest first','','warning');return;}
            // if(!servedBy){alert('Select served by');return;}

            var selected_address_temp_id = null;
            var selected_address_id = null;
            if(isDelivered){
                selected_address_temp_id = document.getElementById("selected_address_temp_id").value;
                selected_address_id = document.getElementById("selected_address_id").value;
                if(selected_address_temp_id == "" && selected_address_id == ""){
                    makeAlert('Select delivery address','','warning');return;
                }
            }

            var subTotal = document.getElementById('sub_total_txt').innerHTML * 1;
            var serviceCharge = document.getElementById('service_charge_txt').innerHTML * 1;
            var vat = document.getElementById('vat_txt').innerHTML * 1;
            var grandTotal = document.getElementById('grandTotal').innerHTML * 1;
            var deliveryCharge = document.getElementById('deliveryCharge').value * 1;

            var discountType = document.getElementById('discountType').value ;
            var discountAmount = document.getElementById('discountAmount').value * 1;
            var shownBill = document.getElementById('shownBill').innerHTML * 1;
            var discountCategory = document.getElementById('discountCategory').value;
            if(discountCategory=="") discountCategory = 0;
            var dineInPerson = document.getElementById('dineInPerson').value;

            var orderInfo = {
                concern:concern,
                salesType:salesType,
                isDelivered:isDelivered,
                tableOrRoom:tableOrRoom,
                table:table,
                customer:customer,
                servedBy:servedBy,
                subTotal:subTotal,
                shownBill:shownBill,
                serviceCharge:serviceCharge,
                vat:vat,
                grandTotal:grandTotal,
                discountType:discountType,
                discountAmount:discountAmount,
                deliveryCharge:deliveryCharge,
                addressData:obj,
                selected_address_temp_id:selected_address_temp_id,
                selected_address_id:selected_address_id,
                discountCategory:discountCategory,
                dineInPerson:dineInPerson,
                _token: '{{ csrf_token() }}',
            };


            startProcessing('doneOrderBtn');
            waitingSection(true);
            $.post('{{ route('save_pos_order_by_ajax') }}', orderInfo, function(data){

                // console.log(data);return;

                if(data.message == "success"){
                    getTablesItem();
                    makeTableBooked();
                    makeAlert('Success','Order added successful','success');
                }
                else if(data.message == "no_item"){
                    makeAlert('Warning','No product selected','warning');
                }
                else if(data.message == false){
                    var stockNeed = data.stockNeed;
                    var productIngNams = data.productIngNams;
                    var ingIds = Object.keys(stockNeed);

                    var message = `<p style="text-align: left !important; font-weight: bold;">Not enough ingredient for this order.</p>
                                    <table style="margin-top: 5px; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th colspan="2" style="text-align:center;">Needed Ingredient List</th>
                                            </tr>
                                            <tr>
                                                <th >Name</th>
                                                <th >Amount</th>
                                            </tr>
                                        </thead>
                                    <tbody>`;
                    for(var i = 0; i < ingIds.length; i++){
                        message += `<tr>
                                        <td >${productIngNams[ingIds[i]]}</td>
                                        <td >${stockNeed[ingIds[i]]}</td>
                                    </tr>`;
                    }

                    message += `</tbody>
                            </table>`;

                    makeAlert('Warning',message,'warning');
                }
                endProcessing('doneOrderBtn');
                waitingSection(false);
            });
        }

        function writeAmount(ele){
            // var totalBill = $('#shownBill').html()*1;
            // var value = ele.value;
            // if(value > totalBill) ele.value = totalBill;

            // if(ele.id=="amount"){
            //     $("#second_amount").val(totalBill - ele.value);
            // }else{
            //     $("#amount").val(totalBill - ele.value);
            // }
        }


        function saveFinal(returnValue = 0) {
            var tableId = $('#tableIdNo').val();
            var totalBill = $('#totalBill').val();
            var shownBill = $('#shownBill').html()*1;
            var discountAmount = totalBill - shownBill;
            var payment_way = $('#payment_way').val();
            var first_paymentMethod = $('#first_paymentMethod').val();
            var first_option_payment_amount = $('#first_option_payment_amount').val();
            var second_paymentMethod = $('#second_paymentMethod').val();
            var second_option_payment_amount = $('#second_option_payment_amount').val();
            var clientId = $('#clientId').val();
            var servedBy = $('#servedBy').val();

            $.ajax({
                method: "post",
                url: 'saveOrderPos.php',
                data: {
                    funName: "perfectOrder",
                    tableId: tableId,
                    discountAmount: discountAmount,
                    payment_way:payment_way,
                    first_paymentMethod: first_paymentMethod,
                    first_option_payment_amount: first_option_payment_amount,
                    second_paymentMethod: second_paymentMethod,
                    second_option_payment_amount: second_option_payment_amount,
                    clientId: clientId,
                    servedBy: servedBy
                }
            })
            .done(function(response) {
                if (response != null) {
                    var uniqueOrderId = parseInt(response);
                    if (returnValue) {
                        orderId = uniqueOrderId;
                        return uniqueOrderId;
                    } else {
                        reloadListPos();
                        reloadTableList(tableId);
                    }
                } else {
                    swal("Could Not Save The Data !", {
                        icon: "error",
                    });
                }
            });
        }

        function loadSizes(productId, productName, image) {
            //getProductSizesFromProductIdForPos
            var salesType =  $("#sales_type").val();

            $('#productName').html(productName);
            $("#selectedImg").attr("src", image);
            $('#productId').val(productId);
            $('#productQuantity').val("1");

            waitingSection(true);
            $.ajax({
                method: "get",
                url: "{{ route('product_sizes') }}",
                data: {
                    productId: productId
                }
            })
            .done(function(response) {
                if (response != null) {

                    var html = `<ul class="unstyled centered">`;
                    for(var i=0; i<response.length; i++){
                        var size = response[i];
                        var price = null;
                        if(salesType == 1)price = size.selling_price;
                        if(salesType == 2)price = size.wholesale_price;
                        if(salesType == 3)price = size.corporate_price;

                        html +=  `<li>
                                    <input class="styled-checkbox" id="psize${size.id}" type="radio" value="${size.id}" name="productSizeId" onclick="loadOptions('${productId}', '${size.id}');">
                                    <label for="psize${size.id}">${size.size_name} (৳ ${price})</label>
                                </li>`;
                    }
                    html += `</ul>`;

                    $('#sizeHolder').html(html);
                    loadOptions(productId);
                    switchProductOrList("product");
                }
                waitingSection(false);
            });
        }

        function loadOptions(productId, productSizeId=null) {

            waitingSection(true);
            $.ajax({
                method: "get",
                url: "{{ route('product_option_addon') }}",
                data: {
                    funName: "getProductOtionDetailsFromSizeIdForPos",
                    productSizeId: productSizeId,
                    productId: productId
                }
            })
            .done(function(response) {

                var options = response.options;
                var addons = response.addons;

                var html = ``;

                if((options.length + addons.length)>0){
                    html = `<div class="row">`;

                    if(options.length > 0){
                        html += `<div class="col-6 col-xl-12">
                                    <span class="fk-addons-table__info-text text-capitalize text-primary" style="font-size: 13; ">
                                        Choose Your Flavour (Any One)
                                    </span>
                                    <ul class="unstyled centered">`;

                        for(var i=0; i<options.length; i++){
                            html += `<li style="font-size:12px;">
                                        <input class="styled-checkbox" id="po${options[i].id}" type="radio" value="${options[i].id}" name="productOptionIds">
                                        <label for="po${options[i].id}">${options[i].name}+৳${options[i].extra_price}</label>
                                    </li>`;
                        }
                        html += `</ul></div>`;
                    }


                    if(addons.length > 0){
                        html += `<div class="col-6 col-xl-12">
                                    <span class="fk-addons-table__info-text text-capitalize text-primary" style="font-size: 13px;  ">
                                        Choose Your Sauce (Any Two)
                                    </span>
                                    <ul class="unstyled centered">`;

                        for(var i=0; i<addons.length; i++){
                            html += `<li style="font-size:12px;">
                                        <input onclick="selectAddons(event)" class="styled-checkbox productAddons" id="ad${addons[i].id}" type="checkbox" value="${addons[i].id}" name="productAddonIds[]">
                                        <label for="ad${addons[i].id}">${addons[i].name}+৳${addons[i].extra_money_added}</label>
                                    </li>`;
                        }

                        html += `</ul></div>`;
                    }
                    html += `</div>`;

                }else{
                    html = "No Options or Addons";
                }


                $("#optionHolder").html(html);
                waitingSection(false);

            });
        }

        function selectAddons(event){
            var elements  = document.getElementsByClassName("productAddons");
            var ckCont = 0;
            for(var i = 0; i < elements.length; i++){
                var ele = elements[i];
                if(ele.checked)ckCont++;
                if(ckCont>2)ele.checked = false;
            }
            if(ckCont>2)event.preventDefault();
        }

        $(document).ready(function() {
            const minus = $('.quantity__minus');
            const plus = $('.quantity__plus');
            const input = $('.quantity__input');
            minus.click(function(e) {
                e.preventDefault();
                var value = input.val();
                if (value > 1) {
                    value--;
                }
                input.val(value);
            });

            plus.click(function(e) {
                e.preventDefault();
                var value = input.val();
                value++;
                input.val(value);
            })
        });
        //Partial Payment Method system implementation Start here
        function payment_way(payment_way){
            if(payment_way == 'partial'){
                document.getElementById("amount").value = null;
                document.getElementById("amount").removeAttribute("disabled");
                document.getElementById("second_paymentMethod").removeAttribute("disabled");
                document.getElementById("second_amount").removeAttribute("disabled");
            }else{
                document.getElementById("second_amount").value = null;
                document.getElementById("amount").value = $('#shownBill').html() * 1;
                document.getElementById("amount").setAttribute("disabled", "disabled");
                document.getElementById("second_paymentMethod").setAttribute("disabled", "disabled");
                document.getElementById("second_amount").setAttribute("disabled", "disabled");
            }
        }

        function payment_amountRequirement(value,type){
            var totalBill = 0;
            var discountedPrice = parseInt($('#shownBillDis').val());
            if(discountedPrice > 0){
               totalBill = discountedPrice;
            }else{
                totalBill = parseInt($('#totalBill').val())
            }

            if(type=='first'){
                var finalValue = totalBill - parseInt($('#first_option_payment_amount').val());
                $("#second_option_payment_amount").val(finalValue);
                $("#first_option_payment_amount").attr("max", totalBill);
                if (parseInt(value) > totalBill) {
                    $('#first_option_payment_amount').val(totalBill);
                    $("#first_amount_error").html("Amount cannot be greater than ৳"+totalBill);
                } else {
                    $("#first_amount_error").empty();
                }
            }else{
                var finalValue = totalBill - parseInt($('#first_option_payment_amount').val());
                $("#second_option_payment_amount").attr("max", finalValue);
                if (parseInt(value) > finalValue) {
                    $('#second_option_payment_amount').val(finalValue);
                    if(finalValue > 0){
                        $("#second_amount_error").html("Amount cannot be greater than ৳"+ finalValue);
                    }else{
                        $("#second_amount_error").html("You have no amount for second payment");
                    }
                } else {
                    $("#second_amount_error").empty();
                }
            }
        }

        function discountAndDelivery() {
            var discountAmount = document.getElementById('discountAmount').value;
            discountAmount = discountAmount * 1;

            if(discountAmount < 0) {discountAmount = 0; document.getElementById('discountAmount').value = 0; return;}
            var showBill = 0;
            var totalBill = $('#grandTotal').html()*1;
            var discountType = $('#discountType').val();
            if (discountType == 1) {
                showBill = totalBill - discountAmount;
            } else {
                showBill = totalBill - ((totalBill * discountAmount) / 100);
            }

            var deliveryAmount = document.getElementById('deliveryCharge').value;
            deliveryAmount = deliveryAmount * 1;
            if(deliveryAmount < 0) {deliveryAmount = 0; document.getElementById('deliveryCharge').value = 0; return;}

            showBill += deliveryAmount;

            showBill = showBill.toFixed(2);
            $('#shownBill').html( showBill>0 ? showBill:0 );
            if($("#payment_way").val() == "one_way"){
                $('#amount').val( showBill>0 ? showBill:0 );
            }
        }

        function cartUpdate(productId, productSizeId, productOptionIds, productAddonIds, subCategoryAddonIds, productQuantity) {
            var tableId = $('#tableIdNo').val();
            $.ajax({
                method: "post",
                url: 'addtocartpos.php',
                data: {
                    tableIdNo: tableId,
                    productId: productId,
                    productSizeId: productSizeId,
                    productOptionIds: productOptionIds,
                    productAddonIds: productAddonIds,
                    subCategoryAddonIds: subCategoryAddonIds,
                    productQuntity: productQuantity,
                    updateFrom: "cartPage"
                }
            })
            .done(function(response) {
                reloadListPos();
            });
        }

        function reloadListPos(tableId = "") {
            if (tableId == "") {
                tableId = $("input[name='tableId']:checked").val();
            }

            $('#tableIdNo').val(tableId);


            $.ajax({
                method: "post",
                url: '../ajaxfunctions.php',
                data: {
                    funName: "reloadListPos",
                    tableId: tableId
                }
            })
            .done(function(response) {

                if (response != null) {

                    $('#listHolder').html(response);
                    reloadTableList(tableId);
                    $("input[name='tableId']").val(["" + tableId]);
                    $('#listHolder').scrollTop($('#listHolder').height());

                } else {
                    swal("Request Can't Be Processed !", {
                        icon: "error",
                    });
                }

            });

        }

        function removeSingleCartItemPos(tableId, productId, productSizeId, productOptionIds, productAddonIds, subCategoryAddonIds) {
            $.ajax({
                method: "post",
                url: '../ajaxfunctions.php',
                data: {
                    funName: "deleteSingleItemFromCartPos",
                    tableId: tableId,
                    productId: productId,
                    productSizeId: productSizeId,
                    productOptionIds: productOptionIds,
                    productAddonIds: productAddonIds,
                    subCategoryAddonIds: subCategoryAddonIds
                }
            })
            .done(function(response) {
                $('#listHolder').html(response);
            });
        }

        function reloadTableList(tableId) {
            $.ajax({
                method: "post",
                url: '../ajaxfunctions.php',
                data: {
                    funName: "reloadTableList"
                }
            })
            .done(function(response) {
                $('#tableHolder').html(response);
                $("input[name='tableId']").val(["" + tableId]);
            });
        }
    </script>

    <script>
        function findCustomer(callback=null){

            var concern = document.getElementById("concern").value*1;
            var phone = document.getElementById("search_phone").value.trim();
            var name = document.getElementById("search_name").value.trim();

            if(phone == "" && name == "") { makeAlert('Enter Phone or Name','','warning');return;}

            waitingSection(true);
            $.get('{{ route('search_customer') }}', {phone:phone, name:name,concern:concern}, function(data){
                // console.log(data);
                var html = ``;
                for(var i=0; i<data.length; i++){
                    html += `<tr>
                                <td style="margin:0; padding:0;">${data[i].name}</td>
                                <td style="margin:0; padding:0;">${data[i].phone}</td>
                                <td style="margin:0; padding:0;" >
                                    <div class="d-flex justify-content-end">
                                        <button style="border-radius: 2px; color: #fff;background-color: #158df7;border-color: #158df7; margin: 3px;" onclick="customerDetails(${data[i].id})">Details</button>
                                        <button id="guest_${data[i].id}" style="border-radius: 2px; color: #fff;background-color: #158df7;border-color: #158df7; margin: 3px;" onclick="selectCustomer(${data[i].id}, '${data[i].name}','${data[i].discount_category}')" data-dismiss="modal">Select</button>
                                    </div>
                                </td>
                              </tr>`;
                }
                document.getElementById("customer_container").innerHTML = html;
                if(callback!=null) callback();
                waitingSection(false);
            });

        }

        function addOrSelect(){
            var ele = document.getElementById("addOrSelectBtn");
            if(ele.innerHTML == "Add New"){
                ele.innerHTML = "Select Customer";
                var customerList = document.getElementById("customer_list");
                customerList.classList.add("d-none");
                var findOrAddBtn = document.getElementById("findOrAdd");
                findOrAddBtn.innerHTML = "Add";
                findOrAddBtn.onclick = addcustomer;
            }else{
                ele.innerHTML = "Add New";
                var customerList = document.getElementById("customer_list");
                customerList.classList.remove("d-none");
                var findOrAddBtn = document.getElementById("findOrAdd");
                findOrAddBtn.innerHTML = "Find";
                // findOrAddBtn.onclick = findCustomer;
                findOrAddBtn.onclick = () => findCustomer(callback=null);
            }
        }

        function addcustomer(){
            var phone = document.getElementById("search_phone").value;
            var name = document.getElementById("search_name").value;
            name = name.trim();
            phone = phone.trim();
            if(name == "")makeAlert('Enter Name','','warning');
            if(phone == "")makeAlert('Enter phone','','warning');

            if(name != "" && phone != ""){
                waitingSection(true);
                $.get('{{ route('add_customer_by_ajax') }}', {phone:phone, name:name}, function(data){
                    if(data == "exist") makeAlert('Warning','Customer Already Exist','warning');
                    findCustomer(function(){
                        addOrSelect();
                    });
                    waitingSection(false);
                });
            }
        }


        function selectCustomer(id, name, discount){
            // console.log(id+" "+name+" "+discount);
            document.getElementById("selectedCustomerName").value = name;
            document.getElementById("selectedCustomerId").value = id;
            document.getElementById("customerDiscountId").value = discount;
            if(discount > 0){
                var ele = document.getElementById("discountCategory");
                if(ele){
                    ele.value = discount;
                    selectDiscountCategory(ele);
                    discountAndDelivery();
                    ele.disabled = true;
                }
            }
            else{
                var ele = document.getElementById("discountCategory");
                if(ele){ele.disabled = false;}
            }

            getcustomerAddress();
        }

        function concernWiseAllData(companyId){

            document.getElementById("selectedProductList").innerHTML = `<h6>Selected product list</h6>`;

            if(!companyId){
                document.getElementById("tableHolder").innerHTML = "";
                document.getElementById("servedBy").innerHTML = `<option value="">-- Select --</option>`;

                document.getElementById("productSection").innerHTML = productPlaceHolder(20);
                document.getElementById("categorySection").innerHTML = categoryPlaceHolder(15);
                return;
            }

            waitingSection(true);
            $.get('{{ route('get_tables_and_rooms_by_ajax') }}', {companyId:companyId}, function(res){
                var html = `<div class="d-flex">
                                <div class="p-2">
                                    <label style="display: flex; align-items: center;">
                                        <input id="isDelivered" onclick="deliverdOrDineIn(this)" style="height: 30px; width: 30px; margin-right: 5px;" type="checkbox">
                                        <span id="deliverySection">Will the order be delivered?</span>
                                    </label>
                                </div>
                                <div class="ml-auto p-2">
                                    <button onclick="getTodaysOrders()" class="btn btn-sm btn-success" style="border-radius:10px" data-toggle="modal" data-target="#todaysOrdersModal">Today's Orders</button>
                                </div>
                            </div>

                            <div id="dineinSection">
                                <label>Select </label>
                                <select id="tableOrRoom" onchange="tableOrRoom()" class="">
                                    @foreach (dineinPlace() as $key => $text)
                                        <option value="{{ $key }}">{{ $text }}</option>
                                    @endforeach
                                </select><br><br>
                                <div id="tablesList" class=" mb-2 " style="background-color: #fff; width: 100%; overflow-x: auto; overflow-y: hidden; white-space: nowrap;" >
                                    <div class="" style="position: sticky; left: 0; z-index: 1;  background-color: #fff; display: inline-block; padding: 15px;">
                                        <input onkeyup="searchTable(this)" type="text" style="width: 60px; padding: 15px; border: 2px solid #c9c7c7; filter: grayscale(100%);" placeholder="🔍">
                                    </div>`;
                        var data = res['tables'];

                        for(var i=0; i<data.length; i++){
                            html += `<div class="d-inline m-1 tableQube" data-tableid="${data[i].id }">
                                        <input onchange="getTablesItem();" type="radio" class="d-none" value="${data[i].id}" id="titable${data[i].id }" name="tableId">
                                        <label onclick="clickOntable(this)" for="titable${data[i].id }" id="tableBtn${data[i].id }" class="p-3 rounded shadow tableBtn" style="background-color: #fff; border:1px solid #c9c7c7; cursor:pointer">${data[i].name }</label>
                                    </div>`;
                        }

                html += `       </div>
                                <div id="roomsList" class=" mb-2" style="background-color: #fff; width: 100%; overflow-x: auto; overflow-y: hidden; white-space: nowrap; display:none;" >
                                    <div class="" style="position: sticky; left: 0; z-index: 1;  background-color: #fff; display: inline-block; padding: 15px;">
                                        <input onkeyup="searchRoom(this)" type="text" style="width: 60px; padding: 15px; border: 2px solid #c9c7c7; filter: grayscale(100%);" placeholder="🔍">
                                    </div>`;

                        data = res['rooms'];
                        for(var i=0; i<data.length; i++){
                            html += `<div class="d-inline roomQube" style="margin: 3px;" data-roomid="${data[i].id }">
                                        <input onchange="getTablesItem();" type="radio" class="d-none" value="${data[i].id}" id="riroom${data[i].id }" name="roomId">
                                        <label onclick="clickOnRoom(this)" for="riroom${data[i].id }" id="roomBtn${data[i].id }" class="p-3 rounded shadow roomBtn" style=" background-color: #fff; border:2px solid #c9c7c7; cursor:pointer">${data[i].room_no}</label>
                                    </div>`;
                        }

                html += `
                                </div>
                            </div>
                            <div id="addressSection" style="display:none;">
                                <div class="ml-auto p-2">
                                    <button  id="addressModalTrogleBtn" data-toggle="modal" data-target="#addressModal" style="display:none;">ddd</button>
                                    <div onclick="clickForSelectAddress(event)"  style="border: 1px solid #000; cursor: pointer; padding: 20px; display: inline-block;">
                                        <div id="default_section" class="btn-link" style="color: #000; ">Select Address</div>
                                        <div id="address_section" class="d-none">
                                            <input type="hidden" id="selected_address_temp_id" name="selected_address_temp_id" value="">
                                            <input type="hidden" id="selected_address_id" name="selected_address_id" value="">
                                            <b id="selected_address_label"></b><br>
                                            <p id="selected_address_text" style="margin: 0px;"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>`;

                document.getElementById("tableHolder").innerHTML = html;
                if({{ $salesType }} != 1){
                    var isDeliveredBtn = document.getElementById("isDelivered");
                    var clickEvent = new Event('click');
                    isDeliveredBtn.checked = true;
                    isDeliveredBtn.dispatchEvent(clickEvent);
                    isDeliveredBtn.disabled = true;
                    isDeliveredBtn.style.display = 'none';
                    document.getElementById("deliverySection").innerHTML = "Select Delivery Address";
                }
                makeTableBooked();
                waitingSection(false);

            });

            waitingSection(true);
            $.get('{{ route('get_server_by_ajax') }}', {companyId:companyId}, function(data){
                var html = '<option value="">-- Select --</option>';
                for(var i=0; i<data.length; i++){
                    html += `<option value="${ data[i].EmployeeID  }">${ data[i].Name  }</option>`;
                }
                document.getElementById("servedBy").innerHTML = html;
                waitingSection(false);
            });
            getConcernWiseCategoryAndProduct(companyId);
        }

        function clickForSelectAddress(event){
            var customer_id = document.getElementById("selectedCustomerId").value;
            if(customer_id == ""){
                event.preventDefault();
                makeAlert('Select Guest First','','warning');
            }else{
                var btn = document.getElementById("addressModalTrogleBtn");
                btn.dispatchEvent(new Event("click"));
            }
        }

        function searchTable(ele){
            var key = ele.value;
            key = key.toLowerCase();
            var elements = document.getElementsByClassName("tableQube");
            for(var i=0; i<elements.length; i++){
                var cube = elements[i];
                var tableId = cube.dataset.tableid;

                var tablename = document.getElementById("tableBtn"+tableId).innerHTML;

                tablename = tablename.toLowerCase();
                if (key.length > 0 && tablename.includes(key)){
                    cube.classList.add('d-inline');
                    cube.classList.remove('d-none');
                }
                else {
                    cube.classList.remove('d-inline');
                    cube.classList.add('d-none');
                }


                if(key.length == 0 ){
                    cube.classList.add('d-inline');
                    cube.classList.remove('d-none');

                    var radio = document.getElementById("titable"+tableId);
                    if(radio.checked == true){
                        const container = cube.parentElement;
                        const scrollLeftPos = cube.offsetLeft - container.offsetLeft - 100;
                        container.scrollLeft = scrollLeftPos;
                    }

                }

            }


        }

        function searchRoom(ele){
            var key = ele.value;
            key = key.toLowerCase();
            var elements = document.getElementsByClassName("roomQube");
            for(var i=0; i<elements.length; i++){
                var cube = elements[i];
                var tableId = cube.dataset.roomid;

                var tablename = document.getElementById("roomBtn"+tableId).innerHTML;

                tablename = tablename.toLowerCase();
                if (key.length > 0 && tablename.includes(key)){
                    cube.classList.add('d-inline');
                    cube.classList.remove('d-none');
                }
                else {
                    cube.classList.remove('d-inline');
                    cube.classList.add('d-none');
                }

                if(key.length == 0 ){
                    cube.classList.add('d-inline');
                    cube.classList.remove('d-none');

                    var radio = document.getElementById("riroom"+tableId);
                    if(radio.checked == true){
                        const container = cube.parentElement;
                        const scrollLeftPos = cube.offsetLeft - container.offsetLeft - 100;
                        container.scrollLeft = scrollLeftPos;
                    }

                }

            }
        }

        function tableOrRoom(){
            var id = document.getElementById("tableOrRoom").value;
           if(id==1){
                document.getElementById('tablesList').style.display = '';
                document.getElementById('roomsList').style.display = 'none';
           }
           if(id==2){
                document.getElementById('tablesList').style.display = 'none';
                document.getElementById('roomsList').style.display = '';
           }
           getTablesItem();
        }

        function makeTableBooked(){
            var concern = document.getElementById("concern").value*1;
            if(!concern){return;}
            waitingSection(true);
            $.get('{{ route('get_booked_table_by_ajax') }}', {concern:concern}, function(data){
                var elements = document.getElementsByClassName("tableBtn");
                for(var i=0; i<elements.length; i++){
                    var forAttribute = elements[i].getAttribute('for');
                    if(document.getElementById(forAttribute).disabled){
                        document.getElementById(forAttribute).disabled = false;
                        elements[i].style.backgroundColor = "#fff";
                        elements[i].style.color = "#000";
                        elements[i].onclick = function() {clickOntable(this);};
                    }
                }

                for(var i=0; i<data.length; i++){
                    var table = data[i];
                    document.getElementById("titable"+table).checked = false;
                    document.getElementById("titable"+table).disabled = true;
                    document.getElementById("tableBtn"+table).style.backgroundColor = "#bcb8e1";
                    document.getElementById("tableBtn"+table).style.color = "#000";
                    document.getElementById("tableBtn"+table).onclick = null;
                }
                waitingSection(false);
            });
        }

        function getConcernWiseCategoryAndProduct(companyId){
            var salesType = document.getElementById("sales_type").value*1;

            waitingSection(true);
            $.get('{{ route('get_concern_wise_category_by_ajax') }}', {companyId:companyId}, function(data){
                var html = `<div>
                                <div class="input-group input-group-sm mb-2" style="width:250px; display: none;">
                                    <div class="input-group-prepend" style="height: 10px;">
                                        <span style="height: 31px;  background-color: #F64E60; color: #fff;" class="input-group-text" id="inputGroup-sizing-sm">Search</span>
                                    </div>
                                    <input style="height: 10px; border: 1px solid #F64E60; color: #F64E60;" placeholder="Category Search" type="text" id="categorySearchKey-old" onkeyup="categorySearch()" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                </div>
                            </div>

                            <div style="background-color: #fff;" class="p-2 p-3 scrollable-div" >

                            <button data-categoryname="All" type="button" class="p-2 rounded-pill shadow " style="font-size: 14px; background-color: #7367f0; color:#fff; border:1px solid #c9c7c7; cursor:pointer" onclick="sortProduct('All',this);">
                                All
                            </button>
                            <input id="categorySearchKey" placeholder="Search Category"  class="p-2 rounded-pill shadow " style="font-size: 14px; color:#000; width: 130px; border:1px solid #c9c7c7;" onkeyup="categorySearch();">
                            `;

                var lib_categories = [];

                for(var i=0; i<data.length; i++){
                    var cetegory = data[i].name;
                    var key = data[i].id;
                    lib_categories[key] = cetegory;
                    html += `<button data-categoryname="${cetegory}" type="button" class="p-2 rounded-pill shadow categoryBtn" style="font-size: 14px; background-color: #fff; border:1px solid #c9c7c7; cursor:pointer" onclick="sortProduct('${(cetegory.replace(/ /g, '_'))+key}',this);">
                                ${cetegory}
                            </button>`;
                }

                if(data.length == 0) html = "No category to show";
                else{html += "</div>";}

                document.getElementById("categorySection").innerHTML = html;

                waitingSection(true);
                $.get('{{ route('get_concern_wise_product_by_ajax') }}', {companyId:companyId, salesType:salesType}, function(products){
                    var productHtml = `<div>
                                            <div class="input-group input-group-sm mb-2" style="width:100%; min-width:250px !important;">
                                                <div class="input-group-prepend" style="height: 10px;">
                                                    <span style="height: 31px; background-color: #7367f0; color: #fff;" class="input-group-text" id="inputGroup-sizing-sm">Search</span>
                                                </div>
                                                <input placeholder="Product Search" style="height: 10px; border: 1px solid #7367f0; color: #7367f0;" type="text" id="productSearchKey" onkeyup="productSearch()" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                            </div>
                                        </div>
                                        <div class="list-group fk-dish row gx-2 mb-5" style="overflow-y: auto; max-height: 75vh;" >`;
                    for(var i=0; i<products.length; i++){
                        var product = products[i];
                        var imageUrl = GBL_IMG_URL+"/"+product.image;
                        productHtml += `<div data-productname="${product.name}" class="single-product t-mb-10 col-md-6 col-lg-4 col-xxl-3 border-0 ${ (product.category_id in lib_categories) ? ((lib_categories[product.category_id].replace(/ /g, '_'))+product.category_id) : '' }" style="cursor: pointer;" onclick="loadSizes('${ product.id }', '${ product.name }', '${imageUrl}'); ">
                                            <div class="fk-dish-card w-100" style="border-radius: 49px !important" >
                                                <div class="fk-dish-card__img w-100" style="border-radius:20px 20px 0px 0px">
                                                    <img src="${imageUrl}" alt="" class="img-fluid m-auto w-100">
                                                </div>
                                                <span class="fk-dish-card__title text-center text-uppercase" style="height: 110px; border-radius:0px 0px 20px 20px ">
                                                    ${ product.name }
                                                </span>
                                            </div>
                                        </div>`;
                    }

                    if(products.length == 0) productHtml = "no product to Show";
                    else{productHtml += "</div>";}

                    document.getElementById("productSection").innerHTML = productHtml;
                    waitingSection(false);
                });

                waitingSection(false);
           });
        }

        function productSearch(){
            var key = document.getElementById('productSearchKey').value;
            var elements = document.getElementsByClassName('single-product');
            for (var i = 0; i < elements.length; i++) {
                var productname = elements[i].dataset.productname;
                elements[i].style.display = 'none';
                productname = productname.toLowerCase();
                key = key.toLowerCase();
                if (productname.includes(key)) {
                    elements[i].style.display = '';
                }
            }

        }

        function categorySearch(){
            var key = document.getElementById('categorySearchKey').value;
            var elements = document.getElementsByClassName('categoryBtn');
            for (var i = 0; i < elements.length; i++) {
                var categoryName = elements[i].dataset.categoryname;
                elements[i].style.display = 'none';
                categoryName = categoryName.toLowerCase();
                key = key.toLowerCase();
                if (categoryName.includes(key)) {
                    elements[i].style.display = '';
                }
            }
        }

        function deliverdOrDineIn(ele){
            if (ele.checked){
                $("#dineinSection").css("display", "none");
                $("#addressSection").css("display", "");
            }
            else {
                $("#dineinSection").css("display", "");
                $("#addressSection").css("display", "none");
                $("#selectedProductList").html('');
            }
            getTablesItem();
        }

        function addProductForTable(){
            var tableOrRoom = document.getElementById("tableOrRoom").value*1;
            var salesType = document.getElementById("sales_type").value*1;
            var concern = document.getElementById("concern").value*1;

            var product = document.getElementById("productId").value*1;
            var productSize = document.querySelector('input[name="productSizeId"]:checked');
            var isDelivered = $("#isDelivered").prop("checked");

            if(!tableOrRoom) {makeAlert('Warning','Select room or table','warning'); return;}

            if(tableOrRoom==1){
                var selectedTable = document.querySelector('input[name="tableId"]:checked');
            }
            if(tableOrRoom==2){
                var selectedTable = document.querySelector('input[name="roomId"]:checked');
            }

            if(!salesType) { makeAlert('Warning','Select sales type','warning');return;}
            if(!concern) {makeAlert('Warning','No concern selected','warning'); return;}
            if(!isDelivered && !selectedTable) {makeAlert('Warning','No table selected','warning');return;}
            if(!product) { makeAlert('Warning','Select any product','warning');return;}
            if(!productSize) {makeAlert('Warning','Select any size','warning');return;}

            var table = !isDelivered ? selectedTable.value : 0;
            tableOrRoom = isDelivered ? 0 : tableOrRoom;

            var size = productSize.value;

            var selectedOption= document.querySelector('input[name="productOptionIds"]:checked');
            var option = selectedOption ? selectedOption.value : null;

            var checkboxes = Array.from(document.querySelectorAll('input[name="productAddonIds[]"]'));
            var productAddons = checkboxes.filter(checkbox => checkbox.checked).map(checkbox => checkbox.value);
            var quantity = document.getElementById("productQuantity").value;
            productAddons = productAddons.sort((a, b) => a - b);

            var data = {
                tableOrRoom:tableOrRoom,
                salesType:salesType,
                concern:concern,
                isDelivered:isDelivered,
                table:table,
                product:product,
                size:size,
                option:option,
                addons:productAddons.join(','),
                quantity:quantity,
            };

            startProcessing('addToListBtn');
            waitingSection(true);
            $.get('{{ route('add_product_to_list_by_ajax') }}', data, function(response){
                endProcessing('addToListBtn');
                getTablesItem();
                switchProductOrList("list");
                waitingSection(true);
                makeAlert('Success','Product added successfully','success')
            });


        }

        function changeItemQuantity(index,ele){

            var quantity = ele.value*1;
            if(quantity < 1 ) {quantity = 1; ele.value = 1;}

            var concern = document.getElementById("concern").value*1;
            var salesType = document.getElementById("sales_type").value*1;
            var tableOrRoom = document.getElementById("tableOrRoom").value*1;
            if(tableOrRoom==1){
                var selectedTable = document.querySelector('input[name="tableId"]:checked');
            }
            if(tableOrRoom==2){
                var selectedTable = document.querySelector('input[name="roomId"]:checked');
            }
            var isDelivered = $("#isDelivered").prop("checked");
            var table = isDelivered ? 0 : selectedTable.value * 1;
            tableOrRoom = isDelivered ? 0 : tableOrRoom;

            waitingSection(true);
            $.get('{{ route('table_item_quantity_update_by_ajax') }}', {concern:concern,salesType:salesType,table:table,itemIndex:index,quantity:quantity,tableOrRoom:tableOrRoom}, function(data){
                getTablesItem();
                waitingSection(false);
            });
        }

        function removeItemFromtable(index){
            var concern = document.getElementById("concern").value*1;
            var salesType = document.getElementById("sales_type").value*1;
            var tableOrRoom = document.getElementById("tableOrRoom").value*1;
            if(tableOrRoom==1){
                var selectedTable = document.querySelector('input[name="tableId"]:checked');
            }
            if(tableOrRoom==2){
                var selectedTable = document.querySelector('input[name="roomId"]:checked');
            }

            var isDelivered = $("#isDelivered").prop("checked");
            var table = isDelivered ? 0 : selectedTable.value * 1;
            tableOrRoom = isDelivered ? 0 : tableOrRoom;
            waitingSection(true);
            $.get('{{ route('remove_table_item_by_ajax') }}', {concern:concern,table:table,itemIndex:index,salesType:salesType,tableOrRoom:tableOrRoom}, function(data){
                getTablesItem();
                waitingSection(false);
            });
        }

        function switchProductOrList(tag){
            var productPanal = document.getElementById("productPanal");
            var listPanal = document.getElementById("listPanal");

            var switchId = document.getElementById("switchId");
            var switchId = window.getComputedStyle(switchId);

            if (!(switchId.display === "none")) {

                if(tag=="list"){
                    productPanal.classList.add("d-none");
                    listPanal.classList.remove("d-none");
                }else if(tag=="product"){
                    listPanal.classList.add("d-none");
                    productPanal.classList.remove("d-none");
                }
            }
        }

        function getTodaysOrders(){
            var concern = document.getElementById("concern").value*1;
            if(!concern) {  makeAlert('Warning','No concern selected','warning');return;}
            var salesType = document.getElementById("sales_type").value*1;
            if(!salesType){return;}
            waitingSection(true);
            $.get('{{ route('get_todays_orders_by_ajax') }}', {concern:concern,salesType:salesType}, function(data){
                $("#todaysOrdersListHolder").html(data);
                waitingSection(false);
            });
        }

        function addNewPaymentway(orderId,concern,paid_amount){
            var ele = document.getElementById("paymentList"+orderId);
            var itemNumber = ele.dataset.items;
            itemNumber = itemNumber*1;
            itemNumber++;

            var enterdvalue = 0;
            var splitBill = document.getElementsByClassName("splitBill"+orderId);
            for(var i=0; i<splitBill.length; i++){
                if(splitBill[i].value < 0) splitBill[i].value = 0;
                enterdvalue += (splitBill[i].value * 1);
            }

            waitingSection(true);
            $.get('{{ route('get_payment_method_selectOptions_by_ajax') }}', {orderId:orderId,concern:concern,itemNumber:itemNumber,paidAmount:paid_amount}, function(data){
                ele.dataset.items = itemNumber;
                var parser = new DOMParser();
                var newItem = parser.parseFromString(data, "text/html").body.firstChild;
                ele.appendChild(newItem);

                document.getElementById("amount"+orderId+'-'+itemNumber).placeholder = paid_amount - enterdvalue;
                document.getElementById("splitBillAddBtn"+orderId).disabled = true;

                rearengSplitBill(orderId,paid_amount)

                waitingSection(false);
            });
        }

        function removePaymentWayItem(id, orderId, totalAmount){
            var elementToRemove = document.getElementById(id);
            elementToRemove.parentNode.removeChild(elementToRemove);
            rearengSplitBill(orderId, totalAmount);
        }

        function checkBill(orderId, totalAmount){
            var ele = document.getElementsByClassName("splitBill"+orderId);

        }

        function saveOrderBill(orderId, totalAmount, uniqueId){
            var splitBill = document.getElementsByClassName("splitBill"+orderId);
            var splitMethod = document.getElementsByClassName("splitMathod"+orderId);

            var enterdvalue = 0;

            var bills = [];
            var method = [];

            for(var i=0; i<splitBill.length; i++){
                if(splitBill[i].value < 0) splitBill[i].value = 0;
                enterdvalue += (splitBill[i].value * 1);
                bills[splitBill[i].dataset.key] = splitBill[i].value;
            }

            for(var i=0; i<splitMethod.length; i++){
                if(splitMethod[i].value == "") { makeAlert('Warning','Payment mode not selected','warning'); return;}
                method[splitMethod[i].dataset.key] = splitMethod[i].value;
            }

            if(totalAmount > enterdvalue){
                 makeAlert('Warning','Total bill less than paid amount','warning');return;
            }
            if(totalAmount < enterdvalue){
                 makeAlert('Warning','Total bill greater than paid amount','warning');return;
            }

            var methodWiseAmount = [];

            for (const key in method) {
                if(!methodWiseAmount[method[key]]) methodWiseAmount[method[key]] = 0;
                methodWiseAmount[method[key]] += bills[key]*1;
            }

            var str = "";

            for (const key in methodWiseAmount) {
                if(str!="") str += ",";
                str += key+"-"+methodWiseAmount[key];
            }

            waitingSection(true);
            $.get('{{ route('save_split_bill_by_ajax') }}', {uniqueId:uniqueId,data:str}, function(data){
                getTodaysOrders();
                makeTableBooked();
                waitingSection(false);
            })
        }

        function Complimentary(uniqueId){
            waitingSection(true);
            $.get('{{ route('make_order_complimentary_by_ajax') }}', {uniqueId:uniqueId}, function(data){
                getTodaysOrders();
                makeTableBooked();
                waitingSection(false);
            });
        }

        function updateOrder(uniqueId){
            var concern = document.getElementById("concern").value*1;
            waitingSection(true);
            $.get('{{ route('updateOrder_from_pos_by_ajax') }}', {uniqueId:uniqueId,concern:concern}, function(data){

                // console.log(data);
                $("#selectedCustomerName").val(data.client_name);
                $("#selectedCustomerId").val(data.client_id);
                $("#customerDiscountId").val(data.discount_category);
                $("#sales_type").val(data.sales_type);
                $("#dineInPerson").val(data.dineIn_person);
                if(data.dineIn_place > 0)$("#tableOrRoom").val(data.dineIn_place);
                $('.js-example-basic-single').select2();

                if(data.isDelivered == 1){
                    var isDeliveredBtn = document.getElementById("isDelivered");
                    var clickEvent = new Event('click');
                    isDeliveredBtn.checked = true;
                    isDeliveredBtn.dispatchEvent(clickEvent);

                    document.getElementById("default_section").classList.add('d-none');
                    document.getElementById("address_section").classList.remove('d-none');
                    document.getElementById("selected_address_temp_id").value = '';
                    document.getElementById("selected_address_id").value = data.delivery_address;
                    document.getElementById("selected_address_label").innerHTML = data.address_label;
                    document.getElementById("selected_address_text").innerHTML = data.local_address;
                    // getcustomerAddress();
                }else{
                    if(data.dineIn_place == 1){
                        var tableBtn = document.getElementById("tableBtn"+data.table_id);
                        tableBtn.onclick = function() {clickOntable(this);};
                    }
                    if(data.dineIn_place == 2){
                        var tableBtn = document.getElementById("roomBtn"+data.table_id);
                    }

                    var clickEvent = new Event('click');
                    tableBtn.dispatchEvent(clickEvent);

                    if(data.dineIn_place == 1)
                        var tableBtn2 = document.getElementById("titable"+data.table_id);
                    if(data.dineIn_place == 2)
                        var tableBtn2 = document.getElementById("riroom"+data.table_id);

                    tableBtn2.disabled = false;
                    var clickEvent = new Event('click');
                    tableBtn2.checked = true;
                    tableBtn2.dispatchEvent(clickEvent);

                    if(data.dineIn_place == 1)clickOntable(tableBtn);
                    if(data.dineIn_place == 2){clickOnRoom(tableBtn);}

                    $("#dineinSection").css("display", "");
                    var isDeliveredBtn = document.getElementById("isDelivered");
                    isDeliveredBtn.checked = false;

                    if(data.dineIn_place==1){
                        document.getElementById('tablesList').style.display = '';
                        document.getElementById('roomsList').style.display = 'none';
                    }
                    if(data.dineIn_place==2){
                        document.getElementById('tablesList').style.display = 'none';
                        document.getElementById('roomsList').style.display = '';
                    }

                    getTablesItem();

                }
                waitingSection(false);
            })
        }

        function cancelOrder(){
            var concern = document.getElementById("concern").value*1;
            var salesType = document.getElementById("sales_type").value*1;
            var tableOrRoom = document.getElementById("tableOrRoom").value*1;
            if(tableOrRoom==1){
                var selectedTable = document.querySelector('input[name="tableId"]:checked');
            }
            if(tableOrRoom==2){
                var selectedTable = document.querySelector('input[name="roomId"]:checked');
            }
            var isDelivered = $("#isDelivered").prop("checked");
            var table = isDelivered ? 0 : selectedTable.value * 1;
            tableOrRoom = isDelivered ? 0 : tableOrRoom;

            waitingSection(true);
            $.get('{{ route('cancel_pos_order_by_ajax') }}', {concern:concern,table:table,salesType:salesType,tableOrRoom:tableOrRoom}, function(data){
                getTablesItem();
                makeTableBooked();
                waitingSection(false);
            });
        }

        function changeSelseType(){
            var concern = document.getElementById("concern").value*1;
            if(!concern) { makeAlert('Warning','No concern selected','warning');return;}

            getConcernWiseCategoryAndProduct(concern);

            var tableOrRoom = document.getElementById("tableOrRoom").value*1;
            if(tableOrRoom == 1){
                var selectedTable = document.querySelector('input[name="tableId"]:checked');
            }
            if(tableOrRoom == 2){
                var selectedTable = document.querySelector('input[name="roomId"]:checked');
            }
            var isDelivered = $("#isDelivered").prop("checked");
            if(selectedTable || isDelivered)getTablesItem();
        }

        function startProcessing(id){
            var addToListBtn = document.getElementById(id);
            if(!addToListBtn){return;}
            addToListBtn.dataset.html = addToListBtn.innerHTML;
            addToListBtn.dataset.bgColor = addToListBtn.style.backgroundColor;
            addToListBtn.innerHTML = "Processing..";
            addToListBtn.style.backgroundColor = "#f64e60";
            addToListBtn.disabled = true;
        }
        function endProcessing(id){
            var addToListBtn = document.getElementById(id);
            if(!addToListBtn){return;}
            var text = addToListBtn.dataset.html;
            var color = addToListBtn.dataset.bgColor;
            if(!text || text == "") return;

            addToListBtn.innerHTML = text;
            addToListBtn.style.backgroundColor = color;
            addToListBtn.disabled = false;
            delete addToListBtn.dataset.html;
            delete addToListBtn.dataset.bgColor;
        }

        function paymentAmountEntry(order_id,ele,totalAmount){
            manageCashAmount(ele.dataset.key,order_id);
            var need = ele.getAttribute('placeholder') * 1;
            if(need < ele.value) ele.value = need;
            if(need > ele.value){
                document.getElementById("splitBillAddBtn"+order_id).disabled = false;
            }
            if(need == ele.value || ele.value == 0 || ele.value == ""){
                document.getElementById("splitBillAddBtn"+order_id).disabled = true;
            }
            rearengSplitBill(order_id,totalAmount);
        }

        function rearengSplitBill(orderId,totalAmount){
            var splitBill = document.getElementsByClassName("splitBill"+orderId);
            var currentPlaceholder = totalAmount;
            var elementNum = splitBill.length;
            var needDeleteId = [];
            var empltInput = false;

            for(var i=0; i<elementNum; i++){
                var ele = splitBill[i];
                var enterdvalue = (ele.value * 1);
                if(ele.value == "" || ele.value == 0){
                    empltInput = true;
                }
                if(currentPlaceholder > 0){
                    ele.placeholder = currentPlaceholder;
                    if(currentPlaceholder < enterdvalue){
                        ele.value = currentPlaceholder;
                    }
                    currentPlaceholder -=  ele.value;
                //    manageCashAmount(ele.dataset.key,orderId);

                }else if(currentPlaceholder <= 0){
                    var pamentModeId = (ele.dataset.key.split('-'))[1];
                    needDeleteId.push("method"+pamentModeId);
                }
            }
            for(var i=0; i<needDeleteId.length; i++){
                var elementToRemove = document.getElementById(needDeleteId[i]);
                elementToRemove.parentNode.removeChild(elementToRemove);
            }

            if(currentPlaceholder > 0) {
                if(!empltInput)document.getElementById("splitBillAddBtn"+orderId).disabled = false;
                document.getElementById("splitBillSaveBtn"+orderId).disabled = true;
            }
            else {
                document.getElementById("splitBillAddBtn"+orderId).disabled = true;
                document.getElementById("splitBillSaveBtn"+orderId).disabled = false;
            }
            rearengSplitBillMethod(orderId);
        }

        function rearengSplitBillMethod(orderId){
            var elements = document.getElementsByClassName("splitMathod"+orderId);
            var idWiseSelectedmethods = [];
            var chashSelected = false;
            var cashAmount = 0;

            for(var i=0; i<elements.length; i++){
                if(elements[i].value != "")
                    idWiseSelectedmethods[elements[i].value] = elements[i].id;

                var key = elements[i].dataset.key;
                var selectedOptionText = elements[i].options[elements[i].selectedIndex].text;
                selectedOptionText = selectedOptionText.trim();
                selectedOptionText = selectedOptionText.toLowerCase();
                if(selectedOptionText == "cash"){
                    chashSelected = true;
                    cashAmount = document.getElementById("amount"+key).value;
                }

            }

            if(chashSelected){
                var received = document.getElementById("cash_received"+orderId).value;
                document.getElementById("cash_chenged"+orderId).value = 0;
                if(cashAmount<received){
                    document.getElementById("cash_chenged"+orderId).value = received - cashAmount;
                }
            }else{
                document.getElementById("cash_received"+orderId).value = 0;
                document.getElementById("cash_chenged"+orderId).value = 0;
            }

            for(var i=0; i<elements.length; i++){
                var options = elements[i].options;

                for (var j = 0; j < options.length; j++) {
                    var option = options[j];
                    var foundKey = idWiseSelectedmethods[option.value];
                    if(foundKey && foundKey != elements[i].id){
                        option.disabled = true;
                        option.style.color = '#FB9BA5';
                    }else{
                        option.disabled = false;
                        option.style.color = '#495057';
                    }
                }
            }
        }

        function manageCashAmount(key,orderId){
            var need = document.getElementById("amount"+key).placeholder * 1;
            var received = document.getElementById("amount"+key).value * 1;


            var replacedKey = key.replace(/-/g, '_');
            var method = document.getElementById("paymentMethod"+replacedKey);
            var selectedOptionText = method.options[method.selectedIndex].text;
            selectedOptionText = selectedOptionText.trim();
            selectedOptionText = selectedOptionText.toLowerCase();

            if(selectedOptionText == "cash"){
                var changed = 0;
                if(need < received){
                    changed = received - need;
                }
                document.getElementById("cash_received"+orderId).value = received;
                document.getElementById("cash_chenged"+orderId).value = changed;
            }
        }

        function selectDiscountCategory(selectElement){
            var amount = 0;
            var type = 1;
            if(selectElement.value >= 1){
                var selectedOption = selectElement.options[selectElement.selectedIndex];
                type = selectedOption.dataset.type;
                amount = selectedOption.dataset.amount;
            }

            document.getElementById("discountType").value = type;
            document.getElementById("discountAmount").value = amount;
            document.getElementById("discountCategoryAmount").value = amount + (type == 2 ? '%' : '');
            discountAndDelivery(document.getElementById("discountAmount").value);

        }

        function addNewAddress(){
            var address = $("#new_address").val();
            var address_specification = $("#new_address_specification").val();
            var address_label = $("#new_address_label").val();

            $("#new_address").val('');
            $("#new_address_specification").val('');
            $("#new_address_label").val('');

            var html = `<div class="card" id="accordion-${GBL_ADDRESS_COUNT}">
                                <div class="card-header" id="heading-${GBL_ADDRESS_COUNT}">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link w-100 text-left" type="button" data-toggle="collapse" data-target="#collapse-${GBL_ADDRESS_COUNT}" aria-expanded="true" aria-controls="collapseOne">
                                            ${address_label}
                                        </button>
                                    </h2>
                                </div>

                                <div id="collapse-${GBL_ADDRESS_COUNT}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion-${GBL_ADDRESS_COUNT}">
                                    <div class="card-body">
                                        <input type="hidden" name="address_id[]" value="">
                                        <input type="hidden" name="temp_id[]" value="${GBL_ADDRESS_COUNT}">
                                        <div class="mb-3">
                                        <label for="" class="form-label">Address</label>
                                        <input type="text" id="address_${GBL_ADDRESS_COUNT}" class="form-control" name="address[]" placeholder="Address" value="${address}">
                                        </div>

                                        <div class="mb-3">
                                        <label for="" class="form-label">Address Specification</label><br>
                                        <textarea id="address_specification_${GBL_ADDRESS_COUNT}" name="address_specification[]" cols="30" rows="2" style="width: 100%;">${address_specification}</textarea>
                                        </div>

                                        <div class="mb-3">
                                        <label for="" class="form-label">Address Label</label>
                                        <input type="text" id="address_label_${GBL_ADDRESS_COUNT}" onchange="changeAddressLabel(this)" name="address_label[]" class="form-control addressLabel" placeholder="Address label" value="${address_label}">
                                        </div>
                                        <div class="mb-3 d-flex content-justify-center" >
                                                <button onclick="setAddress(${GBL_ADDRESS_COUNT})" type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Confirm</button>
                                        </div>
                                    </div>
                                </div>
                            </div>`;

                GBL_ADDRESS_COUNT++;
                var newCartElement = document.getElementById("new_cart");
                newCartElement.insertAdjacentHTML('beforebegin', html);

        }
        function getcustomerAddress(){
            var id = document.getElementById("selectedCustomerId").value;
            if(id=="")return;
            waitingSection(true);
            $.get('{{ route('get_customer_address_by_ajax') }}',{customerId:id}, function(data){
                document.getElementById("addresslist").innerHTML = data.addresses;
                GBL_ADDRESS_COUNT = (data.addressCount*1)+1;
                waitingSection(false);
            });
        }

        function setAddress(id){
            var address = $("#address_"+id).val();
            var address_specification = $("#address_specification_"+id).val();
            var address_label = $("#address_label_"+id).val();

            var element = document.getElementById("default_section");
            element.classList.add("d-none");

            var element = document.getElementById("address_section");
            element.classList.remove("d-none") ;

            $("#selected_address_temp_id").val(id);
            $("#selected_address_id").val('');
            $("#selected_address_label").html(address_label);
            $("#selected_address_text").html(address);
        }

        function waitingSection(type){
            if(document.getElementById("waitingSection")){
                document.getElementById("waitingSection").remove();
            }
            if(type){

                var newElement = document.createElement('div');
                newElement.id = "waitingSection";
                newElement.innerHTML = `
                <div class="modal-backdrop fade show" style="opacity: 0.8 !important; text-align: center; display: flex; justify-content: center; align-items: center; z-index: 1000000;">
                    <h3 style="color: #fff;">Please  wait..</h3>
                </div>`;
                document.body.appendChild(newElement);

            }else{
                if(document.getElementById("waitingSection")){
                    document.getElementById("waitingSection").remove();
                }
            }
        }

        function customerDetails(customerId){
            var concern = document.getElementById("concern").value*1;
            waitingSection(true);
            $.get('{{ route('get_customer_profile_by_ajax') }}', {customerId:customerId,concern:concern}, function(data){
                document.getElementById("customerProfileContent").innerHTML = data;
                waitingSection(false);
            });
        }

        function setDiscountToCustomer(){
            var discount = $("#discountCategoryOnModal").val();
            var customer = $("#selectedCustomerOnModal").val();
            var concern = document.getElementById("concern").value*1;
            waitingSection(true);
            $.get('{{ route('set_discount_to_customer_by_ajax') }}', {discount:discount,customer:customer,concern}, function(data){
                document.getElementById('guest_' + data.id).onclick = () => selectCustomer(data.id, data.name, data.discount_category);
                document.getElementById('guest_profile_' + data.id).onclick = () => selectCustomer(data.id, data.name, data.discount_category);
                selectCustomer(data.id, data.name, data.discount_category);

                waitingSection(false);
            });
        }

        function makeAlert(title="Success", message="", icon="success", ){
            Swal.fire({
                title: title,
                html: message,
                icon: icon,
                confirmButtonText: 'OK',
                confirmButtonColor: '#198754',
                customClass: {
                    confirmButton: 'btn btn-success'
                }
            });
        }

        function makeInvoice(url,uId){
            window.open(url, '_blank');
            document.getElementById("updateOrderBtn"+uId).style.display = 'none';
        }
    </script>
</body>

</html>
