
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>POS | KOT</title>
    <style>
        @page {
            size: auto;
            margin: 0mm;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('pos/style.css') }}">
    <!-- <link href="./2.97fd0627.chunk.css" rel="stylesheet"> -->
    <!-- <link href="./main.e1af72b3.chunk.css" rel="stylesheet"> -->
    <style id="react-to-print-3">
        .apexcharts-canvas {
            position: relative;
            user-select: none;
        }

        .apexcharts-canvas ::-webkit-scrollbar {
            appearance: none;
            width: 6px;
        }

        .apexcharts-canvas ::-webkit-scrollbar-thumb {
            border-radius: 4px;
            background-color: rgba(0, 0, 0, 0.5);
            box-shadow: rgba(255, 255, 255, 0.5) 0px 0px 1px;
        }

        .apexcharts-inner {
            position: relative;
        }

        .apexcharts-text tspan {
            font-family: inherit;
        }

        .legend-mouseover-inactive {
            transition: all 0.15s ease 0s;
            opacity: 0.2;
        }

        .apexcharts-series-collapsed {
            opacity: 0;
        }

        .apexcharts-tooltip {
            border-radius: 5px;
            box-shadow: rgb(153, 153, 153) 2px 2px 6px -4px;
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
            transition: all 0.15s ease 0s;
        }

        .apexcharts-tooltip.apexcharts-active {
            opacity: 1;
            transition: all 0.15s ease 0s;
        }

        .apexcharts-tooltip.apexcharts-theme-light {
            border: 1px solid rgb(227, 227, 227);
            background: rgba(255, 255, 255, 0.96);
        }

        .apexcharts-tooltip.apexcharts-theme-dark {
            color: rgb(255, 255, 255);
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
            background: rgb(236, 239, 241);
            border-bottom: 1px solid rgb(221, 221, 221);
        }

        .apexcharts-tooltip.apexcharts-theme-dark .apexcharts-tooltip-title {
            background: rgba(0, 0, 0, 0.7);
            border-bottom: 1px solid rgb(51, 51, 51);
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
            padding: 0px 10px;
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
            height: 0px;
            line-height: 0;
            padding: 0px !important;
        }

        .apexcharts-tooltip-y-group {
            padding: 6px 0px 5px;
        }

        .apexcharts-tooltip-candlestick {
            padding: 4px 8px;
        }

        .apexcharts-tooltip-candlestick>div {
            margin: 4px 0px;
        }

        .apexcharts-tooltip-candlestick span.value {
            font-weight: bold;
        }

        .apexcharts-tooltip-rangebar {
            padding: 5px 8px;
        }

        .apexcharts-tooltip-rangebar .category {
            font-weight: 600;
            color: rgb(119, 119, 119);
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
            color: rgb(55, 61, 63);
            font-size: 13px;
            text-align: center;
            border-radius: 2px;
            position: absolute;
            z-index: 10;
            background: rgb(236, 239, 241);
            border: 1px solid rgb(144, 164, 174);
            transition: all 0.15s ease 0s;
        }

        .apexcharts-xaxistooltip.apexcharts-theme-dark {
            background: rgba(0, 0, 0, 0.7);
            border: 1px solid rgba(0, 0, 0, 0.5);
            color: rgb(255, 255, 255);
        }

        .apexcharts-xaxistooltip::after,
        .apexcharts-xaxistooltip::before {
            left: 50%;
            border: solid transparent;
            content: " ";
            height: 0px;
            width: 0px;
            position: absolute;
            pointer-events: none;
        }

        .apexcharts-xaxistooltip::after {
            border-color: rgba(236, 239, 241, 0);
            border-width: 6px;
            margin-left: -6px;
        }

        .apexcharts-xaxistooltip::before {
            border-color: rgba(144, 164, 174, 0);
            border-width: 7px;
            margin-left: -7px;
        }

        .apexcharts-xaxistooltip-bottom::after,
        .apexcharts-xaxistooltip-bottom::before {
            bottom: 100%;
        }

        .apexcharts-xaxistooltip-top::after,
        .apexcharts-xaxistooltip-top::before {
            top: 100%;
        }

        .apexcharts-xaxistooltip-bottom::after {
            border-bottom-color: rgb(236, 239, 241);
        }

        .apexcharts-xaxistooltip-bottom::before {
            border-bottom-color: rgb(144, 164, 174);
        }

        .apexcharts-xaxistooltip-bottom.apexcharts-theme-dark::after {
            border-bottom-color: rgba(0, 0, 0, 0.5);
        }

        .apexcharts-xaxistooltip-bottom.apexcharts-theme-dark::before {
            border-bottom-color: rgba(0, 0, 0, 0.5);
        }

        .apexcharts-xaxistooltip-top::after {
            border-top-color: rgb(236, 239, 241);
        }

        .apexcharts-xaxistooltip-top::before {
            border-top-color: rgb(144, 164, 174);
        }

        .apexcharts-xaxistooltip-top.apexcharts-theme-dark::after {
            border-top-color: rgba(0, 0, 0, 0.5);
        }

        .apexcharts-xaxistooltip-top.apexcharts-theme-dark::before {
            border-top-color: rgba(0, 0, 0, 0.5);
        }

        .apexcharts-xaxistooltip.apexcharts-active {
            opacity: 1;
            transition: all 0.15s ease 0s;
        }

        .apexcharts-yaxistooltip {
            opacity: 0;
            padding: 4px 10px;
            pointer-events: none;
            color: rgb(55, 61, 63);
            font-size: 13px;
            text-align: center;
            border-radius: 2px;
            position: absolute;
            z-index: 10;
            background: rgb(236, 239, 241);
            border: 1px solid rgb(144, 164, 174);
        }

        .apexcharts-yaxistooltip.apexcharts-theme-dark {
            background: rgba(0, 0, 0, 0.7);
            border: 1px solid rgba(0, 0, 0, 0.5);
            color: rgb(255, 255, 255);
        }

        .apexcharts-yaxistooltip::after,
        .apexcharts-yaxistooltip::before {
            top: 50%;
            border: solid transparent;
            content: " ";
            height: 0px;
            width: 0px;
            position: absolute;
            pointer-events: none;
        }

        .apexcharts-yaxistooltip::after {
            border-color: rgba(236, 239, 241, 0);
            border-width: 6px;
            margin-top: -6px;
        }

        .apexcharts-yaxistooltip::before {
            border-color: rgba(144, 164, 174, 0);
            border-width: 7px;
            margin-top: -7px;
        }

        .apexcharts-yaxistooltip-left::after,
        .apexcharts-yaxistooltip-left::before {
            left: 100%;
        }

        .apexcharts-yaxistooltip-right::after,
        .apexcharts-yaxistooltip-right::before {
            right: 100%;
        }

        .apexcharts-yaxistooltip-left::after {
            border-left-color: rgb(236, 239, 241);
        }

        .apexcharts-yaxistooltip-left::before {
            border-left-color: rgb(144, 164, 174);
        }

        .apexcharts-yaxistooltip-left.apexcharts-theme-dark::after {
            border-left-color: rgba(0, 0, 0, 0.5);
        }

        .apexcharts-yaxistooltip-left.apexcharts-theme-dark::before {
            border-left-color: rgba(0, 0, 0, 0.5);
        }

        .apexcharts-yaxistooltip-right::after {
            border-right-color: rgb(236, 239, 241);
        }

        .apexcharts-yaxistooltip-right::before {
            border-right-color: rgb(144, 164, 174);
        }

        .apexcharts-yaxistooltip-right.apexcharts-theme-dark::after {
            border-right-color: rgba(0, 0, 0, 0.5);
        }

        .apexcharts-yaxistooltip-right.apexcharts-theme-dark::before {
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
            transition: all 0.15s ease 0s;
        }

        .apexcharts-xcrosshairs.apexcharts-active,
        .apexcharts-ycrosshairs.apexcharts-active {
            opacity: 1;
            transition: all 0.15s ease 0s;
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
            fill: rgb(239, 239, 239);
            stroke: rgb(51, 51, 51);
            rx: 2;
        }

        .apexcharts-svg.apexcharts-zoomable.hovering-zoom {
            cursor: crosshair;
        }

        .apexcharts-svg.apexcharts-zoomable.hovering-pan {
            cursor: move;
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
            color: rgb(110, 129, 146);
            text-align: center;
        }

        .apexcharts-zoom-icon svg,
        .apexcharts-zoomin-icon svg,
        .apexcharts-zoomout-icon svg,
        .apexcharts-reset-icon svg,
        .apexcharts-menu-icon svg {
            fill: rgb(110, 129, 146);
        }

        .apexcharts-selection-icon svg {
            fill: rgb(68, 68, 68);
            transform: scale(0.76);
        }

        .apexcharts-theme-dark .apexcharts-zoom-icon svg,
        .apexcharts-theme-dark .apexcharts-zoomin-icon svg,
        .apexcharts-theme-dark .apexcharts-zoomout-icon svg,
        .apexcharts-theme-dark .apexcharts-reset-icon svg,
        .apexcharts-theme-dark .apexcharts-pan-icon svg,
        .apexcharts-theme-dark .apexcharts-selection-icon svg,
        .apexcharts-theme-dark .apexcharts-menu-icon svg,
        .apexcharts-theme-dark .apexcharts-toolbar-custom-icon svg {
            fill: rgb(243, 244, 245);
        }

        .apexcharts-canvas .apexcharts-zoom-icon.apexcharts-selected svg,
        .apexcharts-canvas .apexcharts-selection-icon.apexcharts-selected svg,
        .apexcharts-canvas .apexcharts-reset-zoom-icon.apexcharts-selected svg {
            fill: rgb(0, 143, 251);
        }

        .apexcharts-theme-light .apexcharts-selection-icon:not(.apexcharts-selected):hover svg,
        .apexcharts-theme-light .apexcharts-zoom-icon:not(.apexcharts-selected):hover svg,
        .apexcharts-theme-light .apexcharts-zoomin-icon:hover svg,
        .apexcharts-theme-light .apexcharts-zoomout-icon:hover svg,
        .apexcharts-theme-light .apexcharts-reset-icon:hover svg,
        .apexcharts-theme-light .apexcharts-menu-icon:hover svg {
            fill: rgb(51, 51, 51);
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
            transform: scale(0.7);
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
            fill: rgb(255, 255, 255);
            stroke: rgb(110, 129, 146);
            stroke-width: 2;
        }

        .apexcharts-pan-icon.apexcharts-selected svg {
            stroke: rgb(0, 143, 251);
        }

        .apexcharts-pan-icon:not(.apexcharts-selected):hover svg {
            stroke: rgb(51, 51, 51);
        }

        .apexcharts-toolbar {
            position: absolute;
            z-index: 11;
            max-width: 176px;
            text-align: right;
            border-radius: 3px;
            padding: 0px 6px 2px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .apexcharts-menu {
            background: rgb(255, 255, 255);
            position: absolute;
            top: 100%;
            border: 1px solid rgb(221, 221, 221);
            border-radius: 3px;
            padding: 3px;
            right: 10px;
            opacity: 0;
            min-width: 110px;
            transition: all 0.15s ease 0s;
            pointer-events: none;
        }

        .apexcharts-menu.apexcharts-menu-open {
            opacity: 1;
            pointer-events: all;
            transition: all 0.15s ease 0s;
        }

        .apexcharts-menu-item {
            padding: 6px 7px;
            font-size: 12px;
            cursor: pointer;
        }

        .apexcharts-theme-light .apexcharts-menu-item:hover {
            background: rgb(238, 238, 238);
        }

        .apexcharts-theme-dark .apexcharts-menu {
            background: rgba(0, 0, 0, 0.7);
            color: rgb(255, 255, 255);
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

        .apexcharts-marker {
            transition: all 0.15s ease 0s;
        }

        @keyframes opaque {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        @keyframes resizeanim {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 0;
            }
        }

        .resize-triggers {
            animation: 1ms ease 0s 1 normal none running resizeanim;
            visibility: hidden;
            opacity: 0;
        }

        .resize-triggers,
        .resize-triggers>div,
        .contract-trigger::before {
            content: " ";
            display: block;
            position: absolute;
            top: 0px;
            left: 0px;
            height: 100%;
            width: 100%;
            overflow: hidden;
        }

        .resize-triggers>div {
            background: rgb(238, 238, 238);
            overflow: auto;
        }

        .contract-trigger::before {
            width: 200%;
            height: 200%;
        }
    </style>
    <style id="react-to-print-4">
        .css-1vb6v1l-SkeletonTheme .react-loading-skeleton {
            background-color: rgb(255, 118, 117);
            background-image: linear-gradient(90deg, rgb(255, 118, 117), rgb(223, 228, 234), rgb(255, 118, 117));
        }

        .css-k31kfd-skeletonStyles-Skeleton {
            background-color: rgb(238, 238, 238);
            background-image: linear-gradient(90deg, rgb(238, 238, 238), rgb(245, 245, 245), rgb(238, 238, 238));
            background-size: 200px 100%;
            background-repeat: no-repeat;
            border-radius: 4px;
            display: inline-block;
            line-height: 1;
            width: 100%;
            animation: 1.2s ease-in-out 0s infinite normal none running animation-16jpnkj;
        }

        @-webkit-keyframes animation-16jpnkj {
            0% {
                background-position: -200px 0px;
            }

            100% {
                background-position: calc(200px + 100%) 0px;
            }
        }

        @keyframes animation-16jpnkj {
            0% {
                background-position: -200px 0px;
            }

            100% {
                background-position: calc(200px + 100%) 0px;
            }
        }

        .css-2b097c-container {
            position: relative;
            box-sizing: border-box;
        }

        .css-yk16xz-control {
            -webkit-box-align: center;
            align-items: center;
            background-color: rgb(255, 255, 255);
            border-color: rgb(204, 204, 204);
            border-radius: 4px;
            border-style: solid;
            border-width: 1px;
            cursor: default;
            display: flex;
            flex-wrap: wrap;
            -webkit-box-pack: justify;
            justify-content: space-between;
            min-height: 38px;
            position: relative;
            transition: all 100ms ease 0s;
            box-sizing: border-box;
            outline: 0px !important;
        }

        .css-yk16xz-control:hover {
            border-color: rgb(179, 179, 179);
        }

        .css-1hwfws3 {
            -webkit-box-align: center;
            align-items: center;
            display: flex;
            flex: 1 1 0%;
            flex-wrap: wrap;
            padding: 2px 8px;
            position: relative;
            overflow: hidden;
            box-sizing: border-box;
        }

        .css-1wa3eu0-placeholder {
            color: rgb(128, 128, 128);
            margin-left: 2px;
            margin-right: 2px;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            box-sizing: border-box;
        }

        .css-1g6gooi {
            margin: 2px;
            padding-bottom: 2px;
            padding-top: 2px;
            visibility: visible;
            color: rgb(51, 51, 51);
            box-sizing: border-box;
        }

        .css-1wy0on6 {
            -webkit-box-align: center;
            align-items: center;
            align-self: stretch;
            display: flex;
            flex-shrink: 0;
            box-sizing: border-box;
        }

        .css-1okebmr-indicatorSeparator {
            align-self: stretch;
            background-color: rgb(204, 204, 204);
            margin-bottom: 8px;
            margin-top: 8px;
            width: 1px;
            box-sizing: border-box;
        }

        .css-tlfecz-indicatorContainer {
            color: rgb(204, 204, 204);
            display: flex;
            padding: 8px;
            transition: color 150ms ease 0s;
            box-sizing: border-box;
        }

        .css-tlfecz-indicatorContainer:hover {
            color: rgb(153, 153, 153);
        }

        .css-19bqh2r {
            display: inline-block;
            fill: currentcolor;
            line-height: 1;
            stroke: currentcolor;
            stroke-width: 0;
        }

        .css-1laao21-a11yText {
            z-index: 9999;
            border: 0px;
            clip: rect(1px, 1px, 1px, 1px);
            height: 1px;
            width: 1px;
            position: absolute;
            overflow: hidden;
            padding: 0px;
            white-space: nowrap;
        }

        .css-1pahdxg-control {
            -webkit-box-align: center;
            align-items: center;
            background-color: rgb(255, 255, 255);
            border-color: rgb(38, 132, 255);
            border-radius: 4px;
            border-style: solid;
            border-width: 1px;
            box-shadow: rgb(38, 132, 255) 0px 0px 0px 1px;
            cursor: default;
            display: flex;
            flex-wrap: wrap;
            -webkit-box-pack: justify;
            justify-content: space-between;
            min-height: 38px;
            position: relative;
            transition: all 100ms ease 0s;
            box-sizing: border-box;
            outline: 0px !important;
        }

        .css-1pahdxg-control:hover {
            border-color: rgb(38, 132, 255);
        }

        .css-1gtu0rj-indicatorContainer {
            color: rgb(102, 102, 102);
            display: flex;
            padding: 8px;
            transition: color 150ms ease 0s;
            box-sizing: border-box;
        }

        .css-1gtu0rj-indicatorContainer:hover {
            color: rgb(51, 51, 51);
        }

        .css-26l3qy-menu {
            top: 100%;
            background-color: rgb(255, 255, 255);
            border-radius: 4px;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 0px 1px, rgba(0, 0, 0, 0.1) 0px 4px 11px;
            margin-bottom: 8px;
            margin-top: 8px;
            position: absolute;
            width: 100%;
            z-index: 1;
            box-sizing: border-box;
        }

        .css-1ew0esf {
            max-height: 200px;
            overflow-y: auto;
            padding-bottom: 4px;
            padding-top: 4px;
            position: relative;
            box-sizing: border-box;
        }

        .css-1n7v3ny-option {
            background-color: rgb(222, 235, 255);
            color: inherit;
            cursor: default;
            display: block;
            font-size: inherit;
            padding: 8px 12px;
            width: 100%;
            user-select: none;
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
            box-sizing: border-box;
        }

        .css-1n7v3ny-option:active {
            background-color: rgb(178, 212, 255);
        }

        .css-yt9ioa-option {
            background-color: transparent;
            color: inherit;
            cursor: default;
            display: block;
            font-size: inherit;
            padding: 8px 12px;
            width: 100%;
            user-select: none;
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
            box-sizing: border-box;
        }

        .css-yt9ioa-option:active {
            background-color: rgb(178, 212, 255);
        }

        .css-1gl4k7y {
            color: rgb(153, 153, 153);
            padding: 8px 12px;
            text-align: center;
            box-sizing: border-box;
        }
    </style>
    <style id="react-to-print-5">
        .tb_button {
            padding: 1px;
            cursor: pointer;
            border-right: 1px solid rgb(139, 139, 139);
            border-left: 1px solid rgb(255, 255, 255);
            border-bottom: 1px solid rgb(255, 255, 255);
        }

        .tb_button.hover {
            background-color: rgb(248, 248, 248) !important;
        }

        .ws_toolbar {
            z-index: 100000;
        }

        .ws_toolbar .ws_tb_btn {
            cursor: pointer;
            border: 1px solid rgb(85, 85, 85);
            padding: 3px;
        }

        .tb_highlight {
            background-color: yellow;
        }

        .tb_hide {
            visibility: hidden;
        }

        .ws_toolbar img {
            padding: 2px;
            margin: 0px;
        }

        textarea {
            background: #ebeef6;
            border: none;
            padding: 5px;

        }
        textarea:hover {
            background: #d2d2d2;
            border: #000;

        }
        @media print {

            textarea {
            background: #ebeef6!important;
            border: none;

            }
        }
    </style>
</head>

<body style="color: black !important;">
    <div>
        <div class="fk-print t-pt-30 t-pb-30">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <!--
                        <span class="d-block fk-print-text fk-print-text--bold text-uppercase fk-print__title text-center mb-2">KONA Café </span>
                        <p class="mb-0 xsm-text fk-print-text text-center text-capitalize">House: 46, Road: 41, Gulshan 2</p>
                        <p class="mb-0 xsm-text fk-print-text text-center text-capitalize">call: 0123457890</p>

 -->
                        <div class="col-12 mt-1 mb-1" style="border-bottom: 1px dashed"></div>
                        <span class="d-block fk-print-text fk-print-text--bold text-uppercase text-center md-text">Kitchen Order Token (KOT)</span>

                        <div class="col-12 mt-1 mb-1" style="border-bottom: 1px dashed"></div>
                        <span class="d-block fk-print-text fk-print-text--bold text-uppercase text-center lg-text">
                            <table class="table mb-0 table-borderless">

                                <thead>
                                    <tr class="text-center">


                                            @if(isset($tables[$order->table_id]))
                                                <td scope="col" class="d-block fk-print-text fk-print-text--bold text-uppercase text-center text-center sm-text">Table No: {{ $tables[$order->table_id] }}</td>
                                                <th>|</th>
                                            @endif

                                                                                <!-- <th>|</th>  -->

                                        <td scope="col" class="d-block fk-print-text fk-print-text--bold text-uppercase text-center text-center sm-text">Order ID: {{ $order->unique_order_id }}</td>
                                        <!-- <td scope="col" class="d-block fk-print-text fk-print-text--bold text-uppercase text-center text-center sm-text">Token: #2833</td> -->

                                    </tr>
                                </thead>
                            </table>
                        </span>




                        <div class="col-12 mt-2 mb-1" style="border-bottom: 1px dashed"></div>

                        <table class="table mb-1 text table-borderless">
                            <thead>
                                <tr style="border-bottom: 1px dashed ">
                                    <th>#</th>
                                    <th scope="col" class="fk-print-text fk-print-text--bold sm-text text-capitalize">description</th>
                                    <th scope="col" class="fk-print-text fk-print-text--bold sm-text text-capitalize text-center">qty</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($orderDetails as $details)
                                    <tr style="border-bottom: 1px dashed ">
                                        <th class="fk-print-text sm-text text-capitalize"><span class="d-block">{{ $loop->index+1}}</span></th>

                                        <th class="fk-print-text xsm-text text-capitalize">
                                            <span class="d-block">
                                                <span class="fk-print-text sm-text text-capitalize">
                                                    {{ $products[$details->product_id] }}
                                                </span>
                                                <br> ({{ $sizes[$details->product_size_id] }}) </span>
                                            <span>
                                            <br>
                                            Options
                                            <br>
                                            @foreach (explode(',',$details->product_option_ids) as $option)
                                                @if($option!="")
                                                    -> {{ $options[$option] }}<br>
                                                @endif
                                            @endforeach
                                            <br>Addons:<br>

                                            @foreach (explode(',',$details->product_addon_ids) as $addon)
                                                @if($addon!="")
                                                    -> {{ $addons[$addon] }}<br>
                                                @endif
                                            @endforeach                                                       <br>
                                                                                                </span>
                                        </th>

                                        <th class="fk-print-text sm-text text-capitalize text-center"><b>{{ $details->product_quantity }}</b></th>

                                    </tr>
                                @endforeach


                                <tr>



                                    <td colspan="3" >
                                        <div style="width:100%; display:flex; justify-content: center;">
                                             <div style="width: 80%;">
                                                <br><label for=""><strong>Comment:</strong></label><br><br>
                                                <textarea style="width: 100%" onkeyup="addComment('{{ $order->unique_order_id }}',this.value)" placeholder="Write comment" name="" id="">{{ $order->kot_comment!=null?$order->kot_comment:"" }}</textarea>
                                            </div>
                                        </div>
                                     </td>
                                </tr>
                            </tbody>

                        </table>
                        <!-- <hr> -->
                        <!-- <hr> -->
                        <!-- <p class="mb-0 xsm-text fk-print-text text-capitalize text-center">bill prepared by: Ariya Stark</p> -->
                        <!-- <span>---------------------------------------------------------------------------------------------------</span> -->

                        <!-- <div class="col-12 mt-2 mb-1" style="border-bottom: 1px dashed"></div> -->

                        <table class="table mt-1 mb-1 text-center table-borderless">
                            <thead>
                                <!-- <tr>
                                    <span scope="col" class="fk-print-text fk-print-text--bold xsm-text text-capitalize text-center">Remarks: </span>
                                    <br>
                                    <br>
                                </tr> -->

                                <tr>
                                    <span scope="col" class="fk-print-text fk-print-text--bold xsm-text text-capitalize" id="datePlaceholder">Date: {{ \Carbon\Carbon::parse($order->order_time)->format('Y-m-d g:i A') }}

                                    </span>
                                    <br>
                                    <span scope="col" class="fk-print-text fk-print-text--bold xsm-text text-capitalize text-center">Billed By: {{ Sentinel::getUser()->first_name . ' ' . Sentinel::getUser()->last_name }}</span>

                                </tr>
                            </thead>
                        </table>
                        <div class="col-12 mt-0" style="border-bottom: 1px dashed"></div>
                        <div class="d-print-none">
                            <button onclick="print()" class="btn btn-sm btn-primary mt-2">Print</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="application/javascript">
        // window.onafterprint = window.close;
        // window.print();

        function addComment(id,data){
            $.ajax({
            method: "post",
            url: '{{ url('add_kot_comment') }}',
            data: {
                id: id,
                data:data,
                _token: '{{ csrf_token() }}'
            }
        })
        .done(function (response) {
            console.log(response);
            if (response != null) {
               
            }
        });
        }

        function print(){
            window.onafterprint = window.close;
            window.print();
        }
    </script>
</body>

</html>
