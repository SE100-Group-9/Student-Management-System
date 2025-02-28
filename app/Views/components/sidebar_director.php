<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">
<div id="sidebar-director" class="sidebar-director">
    <div class="general">
        <div class="general-text">
            <p>Trung tâm</p>
        </div>
    </div>
    <div class="align">
        <div class="news">
            <div class="news-text" id="news" onclick="toggleDeeperNews()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M20 17.0001V11.4521V11.4514C20 10.9176 20 10.6505 19.9351 10.402C19.8775 10.1816 19.7827 9.97268 19.6548 9.78425C19.5104 9.57162 19.3096 9.39574 18.9074 9.04387L14.1074 4.84387C13.3608 4.19059 12.9875 3.86399 12.5674 3.73975C12.1972 3.63027 11.8028 3.63027 11.4326 3.73975C11.0127 3.86392 10.6398 4.19023 9.894 4.8428L9.89278 4.84387L5.09277 9.04387L5.09182 9.04471C4.69032 9.39602 4.48944 9.57179 4.34521 9.78425C4.2173 9.97268 4.12255 10.1816 4.06497 10.402C4 10.6506 4 10.9178 4 11.4521V17.0001C4 17.932 4 18.3978 4.15224 18.7654C4.35523 19.2554 4.74481 19.6448 5.23486 19.8478C5.60241 20 6.06835 20 7.00023 20C7.93211 20 8.39782 20 8.76537 19.8478C9.25542 19.6448 9.64467 19.2554 9.84766 18.7654C9.9999 18.3978 10 17.9319 10 17V16C10 14.8954 10.8954 14 12 14C13.1046 14 14 14.8954 14 16V17C14 17.9319 14 18.3978 14.1522 18.7654C14.3552 19.2554 14.7448 19.6448 15.2349 19.8478C15.6024 20 16.0683 20 17.0002 20C17.9321 20 18.3978 20 18.7654 19.8478C19.2554 19.6448 19.6447 19.2554 19.8477 18.7654C19.9999 18.3978 20 17.932 20 17.0001Z" stroke="#E14177" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Quy định
            </div>
            <svg id="arrow-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="30" viewBox="0 0 24 30" fill="none">
                <path d="M19 11.25L12 20L5 11.25" stroke="#0C0C0D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>
        <div id="news-deeper" class="news-deeper">
            <div class="news-overall">
                <a style="text-decoration: none; background: none; color: inherit;" href="/sms/public/director/title/list">
                    Danh hiệu & Quy định
                </a>
            </div>
        </div>
    </div>
    <div class="align">
        <div class="statics" id="statics" onclick="toggleDeeperClasslist()">
            <div class="statics-text">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M9 20V11H4.59961C4.03956 11 3.75981 11 3.5459 11.109C3.35774 11.2049 3.20487 11.3579 3.10899 11.546C3 11.7599 3 12.0399 3 12.6V20H9ZM9 20H15M9 20V5.59998C9 5.03992 9 4.75993 9.10899 4.54602C9.20487 4.35786 9.35774 4.20487 9.5459 4.10899C9.75981 4 10.0396 4 10.5996 4H13.3996C13.9597 4 14.2405 4 14.4544 4.10899C14.6425 4.20487 14.7948 4.35786 14.8906 4.54602C14.9996 4.75993 15 5.03992 15 5.59998V20M15 20L21 20V9.59998C21 9.03992 20.9996 8.75993 20.8906 8.54602C20.7948 8.35786 20.6425 8.20487 20.4544 8.10899C20.2405 8 19.9601 8 19.4 8H15V20Z" stroke="#01B3EF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Thống kê
            </div>
            <svg id="arrow-icon-2" xmlns="http://www.w3.org/2000/svg" width="24" height="30" viewBox="0 0 24 30" fill="none">
                <path d="M19 11.25L12 20L5 11.25" stroke="#0C0C0D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>
        <div id="statics-deeper" class="statics-deeper">
            <div class="grade">
                <a style="text-decoration: none; background: none; color: inherit;" href="/sms/public/director/statics/grade">
                    Học lực
                </a>
            </div>
            <div class="students">
                <a style="text-decoration: none; background: none; color: inherit;" href="/sms/public/director/statics/student">
                    Học sinh
                </a>
            </div>
            <div class="conducts">
                <a style="text-decoration: none; background: none; color: inherit;" href="/sms/public/director/statics/conduct">
                    Hạnh kiểm
                </a>
            </div>
        </div>
        <div class="general">
            <div class="general-text">
                <p>Học tập</p>
            </div>
        </div>
    </div>
    <div class="align">
        <div class="student" id="student" onclick="toggleDeeperStudent()">
            <div class="student-text">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M17 20C17 18.3431 14.7614 17 12 17C9.23858 17 7 18.3431 7 20M21 16.9999C21 15.7697 19.7659 14.7124 18 14.2495M3 16.9999C3 15.7697 4.2341 14.7124 6 14.2495M18 10.2361C18.6137 9.68679 19 8.8885 19 8C19 6.34315 17.6569 5 16 5C15.2316 5 14.5308 5.28885 14 5.76389M6 10.2361C5.38625 9.68679 5 8.8885 5 8C5 6.34315 6.34315 5 8 5C8.76835 5 9.46924 5.28885 10 5.76389M12 14C10.3431 14 9 12.6569 9 11C9 9.34315 10.3431 8 12 8C13.6569 8 15 9.34315 15 11C15 12.6569 13.6569 14 12 14Z" stroke="#E14177" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Học sinh
            </div>
            <svg id="arrow-icon-3" xmlns="http://www.w3.org/2000/svg" width="24" height="30" viewBox="0 0 24 30" fill="none">
                <path d="M19 11.25L12 20L5 11.25" stroke="#0C0C0D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>
        <div class="student-deeper" id="student-deeper">
            <div class="student-list">
                <a style="text-decoration: none; background: none; color: inherit;" href="/sms/public/director/student/list">
                    Danh sách học sinh
                </a>
            </div>
            <div class="student-payment">
                <a style="text-decoration: none; background: none; color: inherit;" href="/sms/public/director/student/payment">
                    Thông tin thanh toán
                </a>
            </div>
            <div class="report">
                <a style="text-decoration: none; background: none; color: inherit;" href="/sms/public/director/student/record">
                    Thông tin học bạ
                </a>
            </div>
        </div>
    </div>
    <div class="align">
        <div class="class" id="class" onclick="toggleDeeperClass()">
            <div class="class-text">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M17 21C17 18.2386 14.7614 16 12 16C9.23858 16 7 18.2386 7 21M12 13C10.3431 13 9 11.6569 9 10C9 8.34315 10.3431 7 12 7C13.6569 7 15 8.34315 15 10C15 11.6569 13.6569 13 12 13ZM21 6.19995V17.8C21 18.9201 21.0002 19.4802 20.7822 19.908C20.5905 20.2844 20.2841 20.5902 19.9078 20.782C19.48 21 18.9203 21 17.8002 21H6.2002C5.08009 21 4.51962 21 4.0918 20.782C3.71547 20.5902 3.40973 20.2844 3.21799 19.908C3 19.4802 3 18.9201 3 17.8V6.19995C3 5.07985 3 4.51986 3.21799 4.09204C3.40973 3.71572 3.71547 3.40973 4.0918 3.21799C4.51962 3 5.08009 3 6.2002 3H17.8002C18.9203 3 19.48 3 19.9078 3.21799C20.2841 3.40973 20.5905 3.71572 20.7822 4.09204C21.0002 4.51986 21 5.07985 21 6.19995Z" stroke="#01B3EF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Lớp học
            </div>
            <svg id="arrow-icon-5" xmlns="http://www.w3.org/2000/svg" width="24" height="30" viewBox="0 0 24 30" fill="none">
                <path d="M19 11.25L12 20L5 11.25" stroke="#0C0C0D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>
        <div id="class-deeper" class="class-deeper">
            <div class="class-overall">
                <a style="text-decoration: none; background: none; color: inherit;" href="/sms/public/director/class/list">
                    Danh sách lớp học
                </a>
            </div>
        </div>
    </div>
    <div class="general">
        <div class="general-text">
            <p>Quản lý</p>
        </div>
    </div>
    <div class="align">
        <div class="employee" id="employee" onclick="toggleDeeperEmployee()">
            <div class="employee-text">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M3.21799 7.09204L4.10899 7.54603L3.21799 7.09204ZM4.0918 6.21799L4.54579 7.10899L4.0918 6.21799ZM4.0918 17.782L4.54579 16.891H4.54579L4.0918 17.782ZM3.21799 16.908L2.32698 17.362H2.32698L3.21799 16.908ZM20.7822 16.908L19.8912 16.454L20.7822 16.908ZM19.9078 17.782L19.4538 16.891L19.9078 17.782ZM20.7822 7.09204L19.8912 7.54603V7.54603L20.7822 7.09204ZM19.9078 6.21799L20.3618 5.32698V5.32698L19.9078 6.21799ZM11 18C11 18.5523 11.4477 19 12 19C12.5523 19 13 18.5523 13 18H11ZM5 18C5 18.5523 5.44772 19 6 19C6.55228 19 7 18.5523 7 18H5ZM18 15C18.5523 15 19 14.5523 19 14C19 13.4477 18.5523 13 18 13V15ZM14 13C13.4477 13 13 13.4477 13 14C13 14.5523 13.4477 15 14 15V13ZM18 12C18.5523 12 19 11.5523 19 11C19 10.4477 18.5523 10 18 10V12ZM15 10C14.4477 10 14 10.4477 14 11C14 11.5523 14.4477 12 15 12V10ZM9 12C8.44772 12 8 11.5523 8 11H6C6 12.6569 7.34315 14 9 14V12ZM8 11C8 10.4477 8.44772 10 9 10V8C7.34315 8 6 9.34315 6 11H8ZM9 10C9.55228 10 10 10.4477 10 11H12C12 9.34315 10.6569 8 9 8V10ZM10 11C10 11.5523 9.55228 12 9 12V14C10.6569 14 12 12.6569 12 11H10ZM20 9.19995V14.8H22V9.19995H20ZM17.8002 17H6.2002V19H17.8002V17ZM4 14.8V9.19995H2V14.8H4ZM6.2002 7H17.8002V5H6.2002V7ZM4 9.19995C4 8.6234 4.00078 8.25114 4.02393 7.96783C4.04612 7.6962 4.0838 7.59549 4.10899 7.54603L2.32698 6.63805C2.13419 7.01642 2.06287 7.40961 2.03057 7.80495C1.99922 8.18861 2 8.6564 2 9.19995H4ZM6.2002 5C5.65663 5 5.18874 4.99922 4.80498 5.03057C4.40962 5.06286 4.01624 5.13416 3.63781 5.32698L4.54579 7.10899C4.59517 7.08383 4.69595 7.04613 4.9678 7.02393C5.25126 7.00078 5.62365 7 6.2002 7V5ZM4.10899 7.54603C4.205 7.35761 4.35788 7.20474 4.54579 7.10899L3.63781 5.32698C3.07306 5.61473 2.61447 6.07382 2.32698 6.63805L4.10899 7.54603ZM6.2002 17C5.62367 17 5.25127 16.9992 4.96782 16.9761C4.69598 16.9538 4.59519 16.9161 4.54579 16.891L3.63781 18.673C4.01623 18.8658 4.40959 18.9371 4.80496 18.9694C5.18873 19.0008 5.65662 19 6.2002 19V17ZM2 14.8C2 15.3435 1.99922 15.8113 2.03057 16.195C2.06287 16.5904 2.13418 16.9836 2.32698 17.362L4.10899 16.454C4.08381 16.4046 4.04613 16.3039 4.02393 16.0322C4.00078 15.7488 4 15.3765 4 14.8H2ZM4.54579 16.891C4.35778 16.7952 4.20494 16.6424 4.10899 16.454L2.32698 17.362C2.61452 17.9264 3.07317 18.3853 3.63781 18.673L4.54579 16.891ZM20 14.8C20 15.3766 19.9993 15.7489 19.9762 16.0323C19.954 16.3041 19.9163 16.4047 19.8912 16.454L21.6732 17.362C21.8661 16.9835 21.9373 16.5902 21.9696 16.1949C22.0008 15.8112 22 15.3434 22 14.8H20ZM17.8002 19C18.3438 19 18.8115 19.0008 19.1951 18.9694C19.5904 18.9371 19.9835 18.8657 20.3618 18.673L19.4538 16.891C19.4043 16.9162 19.3036 16.9539 19.0321 16.9761C18.7489 16.9992 18.3767 17 17.8002 17V19ZM19.8912 16.454C19.7956 16.6417 19.6425 16.7948 19.4538 16.891L20.3618 18.673C20.9257 18.3856 21.3854 17.927 21.6732 17.362L19.8912 16.454ZM22 9.19995C22 8.6565 22.0008 8.1887 21.9695 7.80511C21.9373 7.40983 21.8661 7.01653 21.6732 6.63805L19.8912 7.54603C19.9164 7.59537 19.954 7.69598 19.9762 7.96767C19.9993 8.25105 20 8.6233 20 9.19995H22ZM17.8002 7C18.3768 7 18.7489 7.00078 19.0321 7.02393C19.3036 7.04611 19.4043 7.08377 19.4538 7.10899L20.3618 5.32698C19.9835 5.13421 19.5904 5.06288 19.1951 5.03057C18.8115 4.99922 18.3437 5 17.8002 5V7ZM21.6732 6.63805C21.3854 6.07316 20.9259 5.61439 20.3618 5.32698L19.4538 7.10899C19.6424 7.20507 19.7956 7.35828 19.8912 7.54603L21.6732 6.63805ZM13 18C13 17.0093 12.3977 16.2349 11.676 15.7537C10.9474 15.268 9.99832 15 9 15V17C9.65854 17 10.2095 17.1798 10.5666 17.4178C10.9307 17.6606 11 17.8861 11 18H13ZM9 15C8.00168 15 7.05265 15.268 6.32398 15.7537C5.6023 16.2349 5 17.0093 5 18H7C7 17.8861 7.06927 17.6606 7.43338 17.4178C7.7905 17.1798 8.34146 17 9 17V15ZM18 13L14 13V15L18 15V13ZM18 10L15 10V12L18 12V10Z" fill="#E14177" />
                </svg>
                Quản lý nhân viên
            </div>
            <svg id="arrow-icon-4" xmlns="http://www.w3.org/2000/svg" width="24" height="30" viewBox="0 0 24 30" fill="none">
                <path d="M19 11.25L12 20L5 11.25" stroke="#0C0C0D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>
        <div class="employee-deeper" id="employee-deeper">
            <div class="teacher">
                <a style="text-decoration: none; background: none; color: inherit;" href="/sms/public/director/employee/teacher/list">
                    Giáo viên
                </a>
            </div>
            <div class="cashier">
                <a style="text-decoration: none; background: none; color: inherit;" href="/sms/public/director/employee/cashier/list">
                    Thu ngân
                </a>
            </div>
            <div class="supervisor">
                <a style="text-decoration: none; background: none; color: inherit;" href="/sms/public/director/employee/supervisor/list">
                    Giám thị
                </a>
            </div>
        </div>
    </div>

</div>

<style>
    .sidebar-director {
        width: 250px;
        height: calc(100%);
        overflow-y: auto;
        display: inline-flex;
        position: relative;
        padding: 20px;
        flex-direction: column;
        align-items: center;
        gap: 15px;
        background: var(--White, #FFF);
        scrollbar-width: thin;
        scrollbar-color: #c1c1c1 #f5f5f5;
        transition: transform 0.3s ease, opacity 0.3s ease;
    }

    .sidebar-director::-webkit-scrollbar {
        width: 8px;
        border-radius: 10px;
    }

    .sidebar-director::-webkit-scrollbar-thumb {
        background-color: #c1c1c1;
        border-radius: 10px;
    }

    .sidebar-director::-webkit-scrollbar-track {
        background: #f5f5f5;
        border-radius: 10px;
    }

    .align {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
        align-self: stretch;
        height: auto;
    }

    .general {
        display: flex;
        height: 30px;
        justify-content: space-between;
        align-items: center;
        align-self: stretch;
    }

    .general-text {
        display: flex;
        height: 30px;
        align-items: center;
        gap: 20px;
        flex: 1 0 0;
    }

    .general-text p {
        flex: 1 0 0;
        color: var(--Silver, #AFAFAF);
        font-family: Inter;
        font-size: 14px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }

    .news,
    .statics,
    .student,
    .class,
    .employee {
        display: flex;
        justify-content: space-between;
        align-items: center;
        align-self: stretch;
        cursor: pointer;
    }

    .news:hover,
    .student:hover,
    .class:hover,
    .employee:hover,
    .statics:hover {
        background: var(--Light-Blue, rgba(109, 207, 251, 0.20));
    }

    .news-text,
    .statics-text,
    .student-text,
    .class-text,
    .employee-text {
        display: flex;
        height: 30px;
        align-items: center;
        gap: 20px;
        display: flex;
        height: 30px;
        align-items: center;
        color: #000;
        font-family: Inter;
        font-size: 14px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }

    .news-deeper,
    .statics-deeper,
    .student-deeper,
    .class-deeper,
    .employee-deeper {
        display: flex;
        height: auto;
        overflow-y: auto;
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
        align-self: stretch;
        transition: max-height 0.3s ease;
    }

    /* Mặc định ẩn tất cả các khung deeper */
    .news-deeper,
    .statics-deeper,
    .student-deeper,
    .class-deeper,
    .employee-deeper {
        max-height: 0;
        /* Ban đầu ẩn */
        overflow: hidden;
        /* Ẩn nội dung tràn ra */
        transition: max-height 0.3s ease;
        /* Hiệu ứng chuyển động */
    }

    .news-deeper.open {
        max-height: 300px;
    }

    .statics-deeper.open {
        max-height: 300px;
        /* Đặt giá trị đủ lớn để chứa nội dung */
    }

    .student-deeper.open {
        max-height: 300px;
    }

    .employee-deeper.open {
        max-height: 300px;
    }

    .class-deeper.open {
        max-height: 300px;
    }

    .news-overall,
    .class-overall,
    .grade,
    .students,
    .conducts,
    .student-list,
    .student-payment,
    .reserved,
    .report,
    .teacher,
    .cashier,
    .supervisor {
        display: flex;
        height: 30px;
        padding: 0px 0px 0px 45px;
        align-items: center;
        gap: 10px;
        align-self: stretch;
        color: #000;
        font-family: Inter;
        font-size: 14px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        cursor: pointer;
    }

    .news-overall:hover,
    :hover,
    .grade:hover,
    .class-overall:hover,
    .students:hover,
    .conducts:hover,
    .student-list:hover,
    .student-payment:hover,
    .reserved:hover,
    .report:hover,
    .teacher:hover,
    .cashier:hover,
    .supervisor:hover {
        background: var(--Light-Blue, rgba(109, 207, 251, 0.20));
    }

    #arrow-icon {
        transition: transform 0.3s ease;
    }

    #arrow-icon-2 {
        transition: transform 0.3s ease;
        /* Thêm hiệu ứng xoay */
    }

    #arrow-icon-3 {
        transition: transform 0.3s ease;
    }

    #arrow-icon-4 {
        transition: transform 0.3s ease;
    }

    #arrow-icon-5 {
        transition: transform 0.3s ease;
    }
</style>

<script>
    function toggleDeeperClasslist() {
        const deeperElement = document.getElementById('statics-deeper');
        const arrowIcon = document.getElementById('arrow-icon-2');

        // Toggle lớp 'open' để bật/tắt hiệu ứng
        if (deeperElement.classList.contains('open')) {
            deeperElement.classList.remove('open');
            arrowIcon.style.transform = 'rotate(0deg)'; // Reset rotation
        } else {
            deeperElement.classList.add('open');
            arrowIcon.style.transform = 'rotate(180deg)'; // Rotate arrow
        }
    }

    function toggleDeeperNews() {
        const deeperElement = document.getElementById('news-deeper');
        const arrowIcon = document.getElementById('arrow-icon');

        // Toggle lớp 'open' để bật/tắt hiệu ứng
        if (deeperElement.classList.contains('open')) {
            deeperElement.classList.remove('open');
            arrowIcon.style.transform = 'rotate(0deg)'; // Reset rotation
        } else {
            deeperElement.classList.add('open');
            arrowIcon.style.transform = 'rotate(180deg)'; // Rotate arrow
        }
    }

    function toggleDeeperStudent() {
        const deeperElement = document.getElementById('student-deeper');
        const arrowIcon = document.getElementById('arrow-icon-3');

        // Toggle lớp 'open' để bật/tắt hiệu ứng
        if (deeperElement.classList.contains('open')) {
            deeperElement.classList.remove('open');
            arrowIcon.style.transform = 'rotate(0deg)'; // Reset rotation
        } else {
            deeperElement.classList.add('open');
            arrowIcon.style.transform = 'rotate(180deg)'; // Rotate arrow
        }
    }

    function toggleDeeperEmployee() {
        const deeperElement = document.getElementById('employee-deeper');
        const arrowIcon = document.getElementById('arrow-icon-4');

        // Toggle lớp 'open' để bật/tắt hiệu ứng
        if (deeperElement.classList.contains('open')) {
            deeperElement.classList.remove('open');
            arrowIcon.style.transform = 'rotate(0deg)'; // Reset rotation
        } else {
            deeperElement.classList.add('open');
            arrowIcon.style.transform = 'rotate(180deg)'; // Rotate arrow
        }
    }

    function toggleDeeperClass() {
        const deeperElement = document.getElementById('class-deeper');
        const arrowIcon = document.getElementById('arrow-icon-5');

        // Toggle lớp 'open' để bật/tắt hiệu ứng
        if (deeperElement.classList.contains('open')) {
            deeperElement.classList.remove('open');
            arrowIcon.style.transform = 'rotate(0deg)'; // Reset rotation
        } else {
            deeperElement.classList.add('open');
            arrowIcon.style.transform = 'rotate(180deg)'; // Rotate arrow
        }
    }
</script>