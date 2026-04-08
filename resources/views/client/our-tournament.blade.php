@extends('layouts.main')

@section('content')
    <style>
        :root {
            --color-internal: #007bff;
            --color-external: #f59e0b;
            --color-friendly: #10b981;
        }

        .card {
            border-radius: 16px;
            border: none;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 123, 255, 0.15);
        }

        .filter-section {
            padding: 20px 0;
            position: sticky;
            top: 0;
            color: black;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            background: linear-gradient(115deg, rgb(10, 14, 24));
        }

        .filter-section {
            transition: background 0.3s ease;
        }

        .filter-select {
            border-radius: 12px;
            border: 2px solid #2d3748;
            font-weight: 500;
            color: #1a202c;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .filter-select option {
            color: #1a202c;
        }

        .filter-select:hover {
            border-color: #007bff;
            transform: translateY(-2px);
            color: black;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.2);
        }

        .filter-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 4px rgba(0, 123, 255, 0.15);
            outline: none;
            color: black;
        }

        .filter-btn {
            border-radius: 12px;
            font-weight: 600;
            padding: 12px;
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
        }

        .filter-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px rgba(0, 123, 255, 0.4);
        }

        .team-logo-container {
            width: 120px;
            height: 120px;
            margin: 0 auto 1rem;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .team-logo {
            width: 100px;
            height: 100px;
            object-fit: contain;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            filter: drop-shadow(0 4px 16px rgba(0, 0, 0, 0.3));
        }

        .card:hover .team-logo {
            transform: scale(1.1);
            filter: drop-shadow(0 8px 24px rgba(0, 123, 255, 0.4));
        }

        .match-badge {
            padding: 8px 16px;
            font-size: 0.75rem;
            border-radius: 20px;
            font-weight: 700;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            text-transform: uppercase;
        }

        .match-vs {
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(135deg, #fff 0%, #e2e8f0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .team-name {
            font-weight: 600;
            font-size: 0.95rem;
            letter-spacing: 0.3px;
            color: #e2e8f0;
            transition: all 0.3s ease;
        }

        .view-details-btn {
            background: #007bff;
            color: white;
            border-radius: 10px;
            padding: 8px 20px;
            font-weight: 600;
            border: none;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
        }

        .view-details-btn:hover {
            transform: translateX(5px);
            box-shadow: 0 6px 16px rgba(0, 123, 255, 0.4);
        }

        .site-section {
            background: rgb(10, 14, 24);
            position: relative;
        }

        .card {
            background: rgba(35, 41, 49, 0.95) !important;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .match-info-text {
            color: #94a3b8;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .match-card-wrapper {
            margin-bottom: 1.5rem;
        }

        /* Category Colors */
        .category-internal {
            --category-color: var(--color-internal);
        }

        .category-external {
            --category-color: var(--color-external);
        }

        .category-friendly {
            --category-color: var(--color-friendly);
        }

        .section-header-internal {
            background: linear-gradient(135deg, rgba(0, 123, 255, 0.1), rgba(0, 123, 255, 0.05));
            border-left: 4px solid #007bff;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .section-header-external {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(245, 158, 11, 0.05));
            border-left: 4px solid #f59e0b;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .section-header-friendly {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(16, 185, 129, 0.05));
            border-left: 4px solid #10b981;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        /* Modal Styling */
        .modal-backdrop.show {
            opacity: 0.5;
        }

        .modal-content {
            background: rgb(10, 14, 24);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
        }

        .modal-header {
            background: transparent;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 20px;
        }

        .modal-header .modal-title {
            color: white;
            font-weight: 700;
        }

        .close-modal-btn {
            background: transparent !important;
            border: none !important;
            color: white !important;
            font-size: 28px !important;
            cursor: pointer !important;
            padding: 0 !important;
            width: 32px !important;
            height: 32px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            transition: all 0.3s ease;
            opacity: 0.7;
            line-height: 1;
        }

        .close-modal-btn:hover {
            opacity: 1;
            transform: scale(1.2) rotate(90deg);
            color: #ef4444 !important;
        }

        .close-modal-btn:active {
            transform: scale(0.95);
        }

        .modal-body {
            padding: 20px;
            color: white;
            max-height: 70vh;
            overflow-y: auto;
        }

        .modal-body::-webkit-scrollbar {
            width: 6px;
        }

        .modal-body::-webkit-scrollbar-track {
            background: rgba(30, 41, 59, 0.4);
            border-radius: 10px;
        }

        .modal-body::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #007bff, #0056b3);
            border-radius: 10px;
        }

        .modal-body::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #0056b3, #003d82);
        }

        @media (max-width: 576px) {
            .hero {
                min-height: 220px !important;
            }

            .hero h1 {
                font-size: 1.5rem !important;
                margin-bottom: 1rem !important;
            }

            .hero p {
                font-size: 0.85rem !important;
                line-height: 1.4;
            }

            .filter-section {
                padding: 12px 0;
                background: linear-gradient(180deg, rgb(10, 14, 24) 60%, rgb(13, 18, 107) 100%);
            }

            .container {
                padding-left: 12px !important;
                padding-right: 12px !important;
            }

            .filter-section h4 {
                font-size: 1rem !important;
                margin-bottom: 12px !important;
                text-align: center;
            }

            .filter-select {
                font-size: 0.8rem;
                padding: 9px 10px;
                margin-bottom: 8px;
            }

            .filter-btn {
                padding: 9px;
                font-size: 0.8rem;
            }

            .match-card-wrapper {
                margin-bottom: 1rem;
            }

            .card {
                border-radius: 10px;
            }

            .card-body {
                padding: 0.6rem 0.5rem !important;
            }

            .card-body .row {
                row-gap: 0.3rem;
                column-gap: 0;
            }

            .card-body .col-4 {
                padding: 0 !important;
                flex: 0 0 calc(33.333% - 0px);
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: flex-start;
            }

            .team-logo-container {
                width: 80px;
                height: 80px;
                margin: 0 auto 0.4rem;
                flex-shrink: 0;
            }

            .team-logo {
                width: 70px;
                height: 70px;
            }

            .team-name {
                font-size: 0.55rem;
                line-height: 1.15;
                font-weight: 600;
                margin-bottom: 0 !important;
                word-break: break-word;
                overflow-wrap: break-word;
                max-width: 100%;
            }

            .match-badge {
                font-size: 0.5rem;
                padding: 3px 7px;
                margin-bottom: 0.5rem !important;
                border-radius: 10px;
                display: inline-block;
                height: auto;
                line-height: 1;
                white-space: nowrap;
            }

            .match-vs {
                font-size: 1.3rem !important;
                margin-bottom: 0.4rem !important;
                margin-top: 0.3rem !important;
                font-weight: 800;
            }

            .card-body h2 {
                font-size: 1.15rem !important;
                margin-bottom: 0.25rem !important;
                margin-top: 0 !important;
                font-weight: 800;
            }

            .match-time {
                margin-bottom: 0.2rem !important;
                margin-top: 0.2rem !important;
            }

            .match-time strong {
                font-size: 0.8rem !important;
                display: block;
            }

            .match-info-text {
                font-size: 0.7rem;
                line-height: 1.2;
                margin-bottom: 0.15rem !important;
                margin-top: 0 !important;
            }

            .card-body small {
                font-size: 0.65rem !important;
                display: block;
                margin-top: 0.15rem;
            }

            .view-details-btn {
                padding: 6px 12px;
                font-size: 0.65rem;
                margin-top: 0.5rem !important;
                border-radius: 6px;
                white-space: nowrap;
                display: inline-block;
                line-height: 1.2;
                font-weight: 600;
            }

            .section-header {
                font-size: 1.15rem !important;
                margin-bottom: 1rem !important;
            }

            .section-header-internal,
            .section-header-external,
            .section-header-friendly {
                padding: 10px 12px;
                margin-bottom: 15px;
                border-left-width: 3px;
            }

            #emptyState {
                padding: 1.5rem 0.8rem !important;
            }

            #emptyState div {
                font-size: 2.5rem !important;
            }

            #emptyState h4 {
                font-size: 0.95rem !important;
                margin-top: 1rem !important;
                margin-bottom: 0.5rem !important;
            }

            #emptyState p {
                font-size: 0.8rem !important;
            }

            .site-section {
                padding: 25px 0 !important;
            }

            .modal-dialog {
                margin: 0.5rem !important;
                max-width: calc(100% - 1rem);
            }

            .modal-body {
                max-height: 65vh;
                padding: 15px !important;
            }

            .modal-header {
                padding: 15px !important;
            }

            .modal-title {
                font-size: 1.1rem !important;
            }
        }

        @media (min-width: 577px) and (max-width: 767px) {
            .hero {
                min-height: 280px !important;
            }

            .hero h1 {
                font-size: 2rem !important;
            }

            .hero p {
                font-size: 0.95rem !important;
            }

            .filter-section {
                padding: 15px 0;
                background: linear-gradient(135deg, rgb(10, 14, 24) 50%, rgb(13, 18, 107) 100%);
            }

            .filter-section h4 {
                font-size: 1.15rem !important;
                margin-bottom: 15px !important;
                text-align: center;
            }

            .filter-select {
                font-size: 0.85rem;
                padding: 10px 12px;
                margin-bottom: 8px;
            }

            .filter-btn {
                padding: 10px;
                font-size: 0.85rem;
            }

            .match-card-wrapper {
                margin-bottom: 1.3rem;
            }

            .card {
                border-radius: 12px;
            }

            .card-body {
                padding: 0.9rem !important;
            }

            .card-body .col-4 {
                padding-left: 6px;
                padding-right: 6px;
            }

            .team-logo-container {
                width: 85px;
                height: 85px;
                margin: 0 auto 0.7rem;
            }

            .team-logo {
                width: 72px;
                height: 72px;
            }

            .team-name {
                font-size: 0.8rem;
                line-height: 1.2;
                font-weight: 600;
            }

            .match-badge {
                font-size: 0.65rem;
                padding: 5px 12px;
                margin-bottom: 0.6rem !important;
                border-radius: 14px;
            }

            .match-vs {
                font-size: 1.4rem !important;
                margin-bottom: 0.5rem !important;
            }

            .card-body h2 {
                font-size: 1.3rem !important;
                margin-bottom: 0.5rem !important;
            }

            .match-time {
                margin-bottom: 0.3rem !important;
            }

            .match-time strong {
                font-size: 0.9rem !important;
            }

            .match-info-text {
                font-size: 0.75rem;
                line-height: 1.3;
                margin-bottom: 0.25rem !important;
            }

            .card-body small {
                font-size: 0.75rem !important;
                margin-top: 0.3rem;
            }

            .view-details-btn {
                padding: 6px 14px;
                font-size: 0.72rem;
                margin-top: 0.45rem !important;
                border-radius: 6px;
                width: auto;
                display: inline-block;
            }

            .section-header {
                font-size: 1.4rem !important;
                margin-bottom: 1.2rem !important;
            }

            #emptyState {
                padding: 2rem 1rem !important;
            }

            #emptyState div {
                font-size: 3.5rem !important;
            }

            #emptyState h4 {
                font-size: 1.05rem !important;
                margin-top: 1.5rem !important;
            }

            #emptyState p {
                font-size: 0.9rem !important;
            }

            .site-section {
                padding: 40px 0 !important;
            }

            .modal-body {
                max-height: 70vh;
            }
        }

        @media (max-width: 359px) {
            .hero {
                min-height: 180px !important;
            }

            .hero h1 {
                font-size: 1.25rem !important;
                margin-bottom: 0.75rem !important;
                letter-spacing: 0.5px !important;
            }

            .hero p {
                font-size: 0.75rem !important;
                line-height: 1.3;
            }

            .filter-section h4 {
                font-size: 0.9rem !important;
                margin-bottom: 10px !important;
            }

            .filter-select {
                font-size: 0.75rem;
                padding: 8px 8px;
                margin-bottom: 6px;
            }

            .filter-btn {
                padding: 8px;
                font-size: 0.75rem;
            }

            .card-body {
                padding: 0.5rem 0.4rem !important;
            }

            .team-logo-container {
                width: 70px;
                height: 70px;
                margin: 0 auto 0.3rem;
            }

            .team-logo {
                width: 60px;
                height: 60px;
            }

            .team-name {
                font-size: 0.5rem;
                line-height: 1.1;
            }

            .match-badge {
                font-size: 0.45rem;
                padding: 2px 5px;
                border-radius: 8px;
            }

            .match-vs {
                font-size: 1.1rem !important;
                margin-bottom: 0.3rem !important;
            }

            .card-body h2 {
                font-size: 1rem !important;
                margin-bottom: 0.2rem !important;
            }

            .match-time strong {
                font-size: 0.7rem !important;
            }

            .match-info-text {
                font-size: 0.65rem;
                margin-bottom: 0.1rem !important;
            }

            .view-details-btn {
                padding: 5px 10px;
                font-size: 0.6rem;
                margin-top: 0.3rem !important;
            }

            #emptyState div {
                font-size: 2rem !important;
            }

            #emptyState h4 {
                font-size: 0.85rem !important;
            }

            #emptyState p {
                font-size: 0.75rem !important;
            }

            .site-section {
                padding: 15px 0 !important;
            }

            .container {
                padding-left: 10px !important;
                padding-right: 10px !important;
            }
        }

        @media (min-width: 360px) and (max-width: 576px) {
            .hero {
                min-height: 220px !important;
            }

            .hero h1 {
                font-size: 1.5rem !important;
                margin-bottom: 1rem !important;
                letter-spacing: 1px !important;
            }

            .hero p {
                font-size: 0.85rem !important;
                line-height: 1.4;
                font-weight: 300;
            }

            .filter-section {
                padding: 12px 0;
            }

            .container {
                padding-left: 12px !important;
                padding-right: 12px !important;
            }

            .filter-section h4 {
                font-size: 1rem !important;
                margin-bottom: 12px !important;
                text-align: center;
                letter-spacing: 0.5px;
            }

            .filter-select {
                font-size: 0.8rem;
                padding: 9px 10px;
                margin-bottom: 8px;
                border-radius: 10px;
            }

            .filter-btn {
                padding: 9px;
                font-size: 0.8rem;
                border-radius: 10px;
            }

            .match-card-wrapper {
                margin-bottom: 1rem;
            }

            .card {
                border-radius: 10px;
            }

            .card-body {
                padding: 0.6rem 0.5rem !important;
            }

            .card-body .row {
                row-gap: 0.3rem;
                column-gap: 0;
            }

            .card-body .col-4 {
                padding: 0 !important;
                flex: 0 0 calc(33.333% - 0px);
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: flex-start;
            }

            .team-logo-container {
                width: 80px;
                height: 80px;
                margin: 0 auto 0.4rem;
                flex-shrink: 0;
            }

            .team-logo {
                width: 70px;
                height: 70px;
            }

            .team-name {
                font-size: 0.55rem;
                line-height: 1.15;
                font-weight: 600;
                margin-bottom: 0 !important;
                word-break: break-word;
                overflow-wrap: break-word;
                max-width: 100%;
            }

            .match-badge {
                font-size: 0.5rem;
                padding: 3px 7px;
                margin-bottom: 0.5rem !important;
                border-radius: 10px;
                display: inline-block;
                height: auto;
                line-height: 1;
                white-space: nowrap;
            }

            .match-vs {
                font-size: 1.3rem !important;
                margin-bottom: 0.4rem !important;
                margin-top: 0.3rem !important;
                font-weight: 800;
            }

            .card-body h2 {
                font-size: 1.15rem !important;
                margin-bottom: 0.25rem !important;
                margin-top: 0 !important;
                font-weight: 800;
            }

            .match-time {
                margin-bottom: 0.2rem !important;
                margin-top: 0.2rem !important;
            }

            .match-time strong {
                font-size: 0.8rem !important;
                display: block;
            }

            .match-info-text {
                font-size: 0.7rem;
                line-height: 1.2;
                margin-bottom: 0.15rem !important;
                margin-top: 0 !important;
            }

            .card-body small {
                font-size: 0.65rem !important;
                display: block;
                margin-top: 0.15rem;
            }

            .view-details-btn {
                padding: 6px 12px;
                font-size: 0.65rem;
                margin-top: 0.5rem !important;
                border-radius: 6px;
                white-space: nowrap;
                display: inline-block;
                line-height: 1.2;
                font-weight: 600;
            }

            .section-header {
                font-size: 1.15rem !important;
                margin-bottom: 1rem !important;
                letter-spacing: 0.5px;
            }

            .section-header-internal,
            .section-header-external,
            .section-header-friendly {
                padding: 10px 12px;
                margin-bottom: 15px;
                border-left-width: 3px;
                border-radius: 6px;
            }

            #emptyState {
                padding: 1.5rem 0.8rem !important;
            }

            #emptyState div {
                font-size: 2.5rem !important;
            }

            #emptyState h4 {
                font-size: 0.95rem !important;
                margin-top: 1rem !important;
                margin-bottom: 0.5rem !important;
                font-weight: 600;
            }

            #emptyState p {
                font-size: 0.8rem !important;
            }

            .site-section {
                padding: 25px 0 !important;
            }

            .modal-dialog {
                margin: 0.5rem !important;
                max-width: calc(100% - 1rem);
                border-radius: 12px;
            }

            .modal-content {
                border-radius: 12px;
            }

            .modal-body {
                max-height: 65vh;
                padding: 15px !important;
                font-size: 0.9rem;
            }

            .modal-header {
                padding: 15px !important;
                border-radius: 12px 12px 0 0;
            }

            .modal-title {
                font-size: 1.1rem !important;
            }
        }

        @media (min-width: 577px) and (max-width: 767px) {
            .hero {
                min-height: 280px !important;
            }

            .hero h1 {
                font-size: 2rem !important;
            }

            .hero p {
                font-size: 0.95rem !important;
            }

            .filter-section {
                padding: 15px 0;
            }

            .filter-section h4 {
                font-size: 1.15rem !important;
                margin-bottom: 15px !important;
                text-align: center;
            }

            .filter-select {
                font-size: 0.85rem;
                padding: 10px 12px;
                margin-bottom: 8px;
                border-radius: 11px;
            }

            .filter-btn {
                padding: 10px;
                font-size: 0.85rem;
                border-radius: 11px;
            }

            .match-card-wrapper {
                margin-bottom: 1.3rem;
            }

            .card {
                border-radius: 12px;
            }

            .card-body {
                padding: 0.9rem !important;
            }

            .card-body .col-4 {
                padding-left: 6px;
                padding-right: 6px;
            }

            .team-logo-container {
                width: 85px;
                height: 85px;
                margin: 0 auto 0.7rem;
            }

            .team-logo {
                width: 72px;
                height: 72px;
            }

            .team-name {
                font-size: 0.8rem;
                line-height: 1.2;
                font-weight: 600;
            }

            .match-badge {
                font-size: 0.65rem;
                padding: 5px 12px;
                margin-bottom: 0.6rem !important;
                border-radius: 14px;
            }

            .match-vs {
                font-size: 1.4rem !important;
                margin-bottom: 0.5rem !important;
            }

            .card-body h2 {
                font-size: 1.3rem !important;
                margin-bottom: 0.5rem !important;
            }

            .match-time {
                margin-bottom: 0.3rem !important;
            }

            .match-time strong {
                font-size: 0.9rem !important;
            }

            .match-info-text {
                font-size: 0.75rem;
                line-height: 1.3;
                margin-bottom: 0.25rem !important;
            }

            .card-body small {
                font-size: 0.75rem !important;
                margin-top: 0.3rem;
            }

            .view-details-btn {
                padding: 6px 14px;
                font-size: 0.72rem;
                margin-top: 0.45rem !important;
                border-radius: 6px;
                width: auto;
                display: inline-block;
            }

            .section-header {
                font-size: 1.4rem !important;
                margin-bottom: 1.2rem !important;
            }

            #emptyState {
                padding: 2rem 1rem !important;
            }

            #emptyState div {
                font-size: 3.5rem !important;
            }

            #emptyState h4 {
                font-size: 1.05rem !important;
                margin-top: 1.5rem !important;
            }

            #emptyState p {
                font-size: 0.9rem !important;
            }

            .site-section {
                padding: 40px 0 !important;
            }

            .modal-body {
                max-height: 70vh;
            }

            .modal-dialog {
                max-width: 90vw;
            }
        }

        @media (min-width: 768px) and (max-width: 991px) {
            .team-logo-container {
                width: 90px;
                height: 90px;
            }

            .team-logo {
                width: 76px;
                height: 76px;
            }

            .team-name {
                font-size: 0.88rem;
            }

            .match-vs,
            .card-body h2 {
                font-size: 1.5rem !important;
            }

            .match-badge {
                font-size: 0.68rem;
                padding: 6px 14px;
            }

            .view-details-btn {
                font-size: 0.8rem;
                padding: 8px 18px;
            }

            .filter-section h4 {
                text-align: left;
            }

            .site-section {
                padding: 50px 0 !important;
            }

            .match-card-wrapper {
                margin-bottom: 1.5rem;
            }

            .card {
                border-radius: 14px;
            }
        }

        @media (min-width: 992px) {
            .hero {
                min-height: 400px !important;
            }

            .hero h1 {
                font-size: 3.5rem !important;
            }

            .hero p {
                font-size: 1.2rem !important;
            }

            .site-section {
                padding: 60px 0 !important;
            }

            .card:hover {
                transform: translateY(-8px);
                box-shadow: 0 20px 40px rgba(0, 123, 255, 0.15);
            }

            .team-logo-container {
                width: 120px;
                height: 120px;
            }

            .team-logo {
                width: 100px;
                height: 100px;
            }

            .card:hover .team-logo {
                transform: scale(1.1);
            }

            .filter-section {
                padding: 20px 0;
            }
        }


        @media print {

            .filter-section,
            .view-details-btn,
            .modal {
                display: none !important;
            }

            .site-section {
                padding: 0 !important;
            }

            .card {
                page-break-inside: avoid;
            }
        }
    </style>

    <!-- Hero Section -->
    <div
        class="hero overlay"
        style="background-image: url('{{ asset('assets/client/images/bg_5.jpg') }}'); min-height: 400px; display: flex; align-items: center;"
    >
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <h1
                        class="mb-4 text-white"
                        style="font-size: 3.5rem; font-weight: 800; letter-spacing: 1px;"
                    >Our Tournament</h1>
                    <p
                        class="text-white"
                        style="font-size: 1.2rem; font-weight: 300; letter-spacing: 0.5px;"
                    >Ikuti perjalanan tim EXPOSE di berbagai kompetisi</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-md-3 mb-md-0 mb-3">
                    <h4
                        class="mb-0 text-white"
                        style="font-weight: 700; letter-spacing: 0.5px;"
                    >
                        Our <span style="color: #007bff;">Tournament</span>
                    </h4>
                </div>

                <div class="col-12 col-md-9">
                    <form
                        id="filterForm"
                        method="GET"
                        action="{{ url('/our-tournament') }}"
                    >
                        <div class="row g-2">
                            <div class="col-6 col-lg-3">
                                <select
                                    id="yearFilter"
                                    name="year"
                                    class="form-control filter-select"
                                >
                                    <option value="all">All Years</option>
                                    @foreach ($years as $year)
                                        <option
                                            value="{{ $year }}"
                                            {{ $selectedYear == $year ? 'selected' : '' }}
                                        >
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 col-lg-3">
                                <select
                                    id="categoryFilter"
                                    name="category"
                                    class="form-control filter-select"
                                >
                                    <option value="all">All Categories</option>
                                    <option
                                        value="internal"
                                        {{ $selectedCategory == 'internal' ? 'selected' : '' }}
                                    >Internal</option>
                                    <option
                                        value="external"
                                        {{ $selectedCategory == 'external' ? 'selected' : '' }}
                                    >External</option>
                                    <option
                                        value="friendly"
                                        {{ $selectedCategory == 'friendly' ? 'selected' : '' }}
                                    >Friendly</option>
                                </select>
                            </div>
                            <div class="col-6 col-lg-3">
                                <select
                                    id="eventFilter"
                                    name="event"
                                    class="form-control filter-select"
                                >
                                    <option value="all"> All Events</option>
                                    @foreach ($events as $event)
                                        <option
                                            value="{{ $event }}"
                                            {{ $selectedEvent == $event ? 'selected' : '' }}
                                        >
                                            {{ $event }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tournament Content -->
    <div
        class="site-section"
        style="position: relative;"
        id="tournamentContent"
    >
        <div class="container">
            @if ($groupedMatches->count() > 0)
                @foreach ($groupedMatches as $groupKey => $matches)
                    @php
                        $groupData = json_decode($groupKey, true);
                        $category = $groupData['category'];
                        $eventType = $groupData['event_type'];

                        $categoryClass = 'section-header-' . $category;
                        $categoryColor = match ($category) {
                            'internal' => '#007bff',
                            'external' => '#f59e0b',
                            'friendly' => '#10b981',
                            default => '#6b7280',
                        };
                        $categoryLabel = match ($category) {
                            'internal' => 'Internal',
                            'external' => 'External',
                            'friendly' => 'Friendly',
                            default => ucfirst($category),
                        };
                    @endphp

                    <div class="mb-5">
                        <div
                            class="{{ $categoryClass }}"
                            style="background: linear-gradient(135deg, rgba({{ $categoryColor }}, 0.1), rgba({{ $categoryColor }}, 0.05)); border-left: 4px solid {{ $categoryColor }}; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px;"
                        >
                            <h4
                                class="section-header text-white"
                                style="font-weight: 700; font-size: 1.75rem; margin: 0;"
                            >
                                <span
                                    style="color: {{ $categoryColor }}; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;"
                                >{{ $categoryLabel }}</span> - {{ $eventType }}
                            </h4>
                        </div>

                        @foreach ($matches as $match)
                            <div class="match-card-wrapper">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row align-items-center g-2">
                                            <!-- Team 1 -->
                                            <div class="col-4 text-center">
                                                <div class="team-logo-container">
                                                    <div class="team-logo-glow"></div>
                                                    <img
                                                        src="{{ $match->team_logo_1 ? asset('storage/' . $match->team_logo_1) : asset('assets/client/images/EXPOSE FC.png') }}"
                                                        alt="{{ $match->teamname_1 }}"
                                                        class="team-logo"
                                                    >
                                                </div>
                                                <h6 class="team-name">{{ $match->teamname_1 }}</h6>
                                            </div>

                                            <!-- Match Info -->
                                            <div class="col-4 text-center">
                                                <span
                                                    class="badge match-badge d-block mb-2 text-white"
                                                    style="background: {{ $categoryColor }};"
                                                >
                                                    {{ strtoupper($match->event_type ?? 'EVENT') }}
                                                </span>

                                                @if ($match->status)
                                                    <h2
                                                        class="mb-2 text-white"
                                                        style="font-size: 1.8rem; font-weight: 800;"
                                                    >
                                                        {{ $match->score_team1 ?? 0 }} - {{ $match->score_team2 ?? 0 }}
                                                    </h2>

                                                    @php
                                                        $totalGoals = $match->goals->count();
                                                    @endphp
                                                    @if ($totalGoals > 0)
                                                        <small
                                                            style="color: #94a3b8; font-size: 0.75rem; display: block; margin-bottom: 0.4rem;"
                                                        >
                                                            ⚽ {{ $totalGoals }} Goal{{ $totalGoals > 1 ? 's' : '' }}
                                                        </small>
                                                    @endif
                                                @else
                                                    <h2 class="match-vs mb-2">VS</h2>
                                                @endif

                                                <p class="match-time mb-1 text-white">
                                                    <strong
                                                        style="font-size: 1.1rem;">{{ \Carbon\Carbon::parse($match->date)->format('H:i') }}
                                                        WIB</strong>
                                                </p>
                                                <p class="match-info-text mb-1">📅
                                                    {{ \Carbon\Carbon::parse($match->date)->format('d F Y') }}</p>
                                                <p class="match-info-text mb-1">📍 {{ $match->venue_name ?? 'TBD' }}</p>

                                                @if ($match->status)
                                                    <small style="color: #10b981; font-weight: 600;">✓ Selesai</small>
                                                @else
                                                    <small style="color: #fbbf24; font-weight: 600;">⏳ Mendatang</small>
                                                @endif

                                                <br>
                                                <button
                                                    type="button"
                                                    class="view-details-btn mt-2"
                                                    onclick="window.location.href='{{ route('tournament.match.detail.page', $match->id) }}'"
                                                    style="background: {{ $categoryColor }};"
                                                >
                                                    Detail Pertandingan
                                                </button>
                                            </div>

                                            <!-- Team 2 -->
                                            <div class="col-4 text-center">
                                                <div class="team-logo-container">
                                                    <div class="team-logo-glow"></div>
                                                    <img
                                                        src="{{ $match->team_logo_2 ? asset('storage/' . $match->team_logo_2) : asset('assets/client/images/EXPOSE FC.png') }}"
                                                        alt="{{ $match->teamname_2 }}"
                                                        class="team-logo"
                                                    >
                                                </div>
                                                <h6 class="team-name">{{ $match->teamname_2 }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @else
                <!-- Empty State -->
                <div
                    id="emptyState"
                    class="py-5 text-center"
                >
                    <div style="font-size: 5rem; opacity: 0.5;">⚽</div>
                    <h4
                        class="mt-4"
                        style="color: #cbd5e1; font-weight: 600;"
                    >No Matches Found</h4>
                    <p
                        class="text-muted"
                        style="font-size: 1.1rem;"
                    >Try adjusting your filters</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Detail Pertandingan -->
    <div
        class="modal fade"
        id="matchDetailModal"
        tabindex="-1"
    >
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div
                class="modal-content"
                style="background: rgb(10, 14, 24); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 16px;"
            >

                <!-- Modal Header -->
                <div
                    class="modal-header"
                    style="border-bottom: 1px solid rgba(255, 255, 255, 0.1); display: flex; justify-content: space-between; align-items: center; padding: 20px;"
                >
                    <h5
                        class="modal-title"
                        style="color: white; font-weight: 700;"
                    >Match Detail</h5>
                    <button
                        type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                        style="background: transparent; border: none; opacity: 0.7; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); width: 1.5rem; height: 1.5rem; display: flex; align-items: center; justify-content: center; color: white; cursor: pointer;"
                        onmouseover="this.style.opacity='1'; this.style.transform='rotate(90deg) scale(1.1)'; this.style.background='rgba(239, 68, 68, 0.2)';"
                        onmouseout="this.style.opacity='0.7'; this.style.transform='none'; this.style.background='transparent';"
                    >
                        <span style="font-size: 1.5rem; line-height: 1;">&times;</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div
                    class="modal-body"
                    id="matchDetailContent"
                    style="max-height: 70vh; overflow-y: auto; padding: 20px;"
                >
                    <div class="py-5 text-center">
                        <div class="spinner-border text-primary"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        /* Modal Styling */
        .modal-backdrop.show {
            opacity: 0.5;
        }

        .modal-content {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
        }

        .modal-header {
            background: rgba(30, 41, 59, 0.6);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding: 20px;
            border-radius: 16px 16px 0 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-title {
            color: white;
            font-size: 1.3rem;
            font-weight: 700;
            margin: 0;
        }

        .modal-body {
            padding: 20px !important;
            color: white;
            max-height: 70vh;
            overflow-y: auto;
        }

        /* Custom Scrollbar untuk Modal */
        .modal-body::-webkit-scrollbar {
            width: 6px;
        }

        .modal-body::-webkit-scrollbar-track {
            background: rgba(30, 41, 59, 0.4);
            border-radius: 10px;
        }

        .modal-body::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #007bff, #0056b3);
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .modal-body::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #0056b3, #003d82);
            box-shadow: 0 0 6px rgba(0, 123, 255, 0.4);
        }

        /* Firefox Scrollbar */
        .modal-body {
            scrollbar-color: #007bff rgba(30, 41, 59, 0.4);
            scrollbar-width: thin;
        }

        /* Btn Close White Styling */
        .btn-close-white {
            background: transparent;
            border: none;
            opacity: 0.7;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            width: 1.5rem;
            height: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            padding: 0;
            cursor: pointer;
        }

        .btn-close-white:hover {
            opacity: 1;
            transform: rotate(90deg) scale(1.1);
            background: rgba(239, 68, 68, 0.2) !important;
        }

        .btn-close-white:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.3);
            opacity: 1;
        }

        @media (max-width: 576px) {
            .modal-dialog {
                margin: 0.5rem !important;
                max-width: calc(100% - 1rem);
            }

            .modal-header {
                padding: 12px 15px !important;
            }

            .modal-title {
                font-size: 1rem !important;
            }

            .modal-body {
                padding: 12px !important;
                max-height: 65vh;
            }
        }
    </style>

    <script>
        // Auto-trigger filter when dropdown changes
        document.addEventListener('DOMContentLoaded', function() {
            const yearFilter = document.getElementById('yearFilter');
            const categoryFilter = document.getElementById('categoryFilter');
            const eventFilter = document.getElementById('eventFilter');
            const contentDiv = document.querySelector('#tournamentContent .container');

            // Function to apply filters
            function applyFilters() {
                const year = yearFilter.value;
                const category = categoryFilter.value;
                const event = eventFilter.value;

                // Show loading state
                contentDiv.innerHTML = `
                <div id="loadingState" class="py-5 text-center">
                    <style>
                        @keyframes pulse {
                            0%, 100% { opacity: 1; }
                            50% { opacity: 0.6; }
                        }
                        @keyframes bounce {
                            0%, 100% { transform: translateY(0); }
                            50% { transform: translateY(-10px); }
                        }
                        .loading-container {
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            gap: 8px;
                            margin-bottom: 2rem;
                        }
                        .loading-ball {
                            width: 12px;
                            height: 12px;
                            border-radius: 50%;
                            background: linear-gradient(135deg, #007bff, #0056b3);
                            animation: bounce 1.4s infinite ease-in-out;
                        }
                        .loading-ball:nth-child(1) {
                            animation-delay: -0.32s;
                        }
                        .loading-ball:nth-child(2) {
                            animation-delay: -0.16s;
                        }
                        .loading-ball:nth-child(3) {
                            animation-delay: 0s;
                        }
                        .loading-text {
                            background: linear-gradient(135deg, #007bff, #0056b3, #007bff);
                            background-size: 200% auto;
                            -webkit-background-clip: text;
                            -webkit-text-fill-color: transparent;
                            background-clip: text;
                            animation: pulse 2s ease-in-out infinite;
                            font-size: 1.5rem;
                            font-weight: 700;
                            margin-bottom: 0.5rem;
                        }
                    </style>
                    <div class="loading-container">
                        <div class="loading-ball"></div>
                        <div class="loading-ball"></div>
                        <div class="loading-ball"></div>
                    </div>
                    <h4 class="loading-text">Memuat Pertandingan...</h4>
                    <p class="text-muted" style="font-size: 1rem; margin: 0; margin-top: 0.5rem;">
                        Harap tunggu sebentar
                    </p>
                </div>
            `;

                fetch(`{{ route('tournament.filter') }}?year=${year}&category=${category}&event=${event}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success && data.html) {
                            contentDiv.innerHTML = data.html;
                        } else if (data.html) {
                            contentDiv.innerHTML = data.html;
                        } else {
                            showEmptyState(contentDiv);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showErrorState(contentDiv, error.message);
                    });
            }

            // Add change event listeners
            if (yearFilter) {
                yearFilter.addEventListener('change', applyFilters);
            }
            if (categoryFilter) {
                categoryFilter.addEventListener('change', applyFilters);
            }
            if (eventFilter) {
                eventFilter.addEventListener('change', applyFilters);
            }
        });

        /**
         * Display empty state when no matches found
         */
        function showEmptyState(contentDiv) {
            contentDiv.innerHTML = `
            <div class="py-5 text-center">
                <div style="font-size: 5rem; opacity: 0.5;">⚽</div>
                <h4 style="color: #cbd5e1; font-weight: 600; margin-top: 1.5rem; margin-bottom: 0.5rem;">
                    No Matches Found
                </h4>
                <p class="text-muted" style="font-size: 1.1rem; margin: 0;">
                    Try adjusting your filters
                </p>
            </div>
        `;
        }

        /**
         * Display error state when fetch fails
         */
        function showErrorState(contentDiv, errorMessage) {
            contentDiv.innerHTML = `
            <div class="py-5 text-center">
                <div style="font-size: 5rem; opacity: 0.5; margin-bottom: 1rem;">⚠️</div>
                <h4 style="color: #cbd5e1; font-weight: 600; margin-bottom: 0.5rem;">
                    Error Loading Matches
                </h4>
                <p class="text-muted" style="font-size: 1.1rem; margin: 0;">
                    ${errorMessage}
                </p>
            </div>
        `;
        }
    </script>
@endsection
