<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">
<div id="sidebar-director" class="sidebar-director">
    <div class="general">
        <div class="general-text">
            <p>Trung tâm</p>
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
                <a style="text-decoration: none; background: none; color: inherit;" href="/sms/public/teacher/statics/grade">
                    Học lực
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
                <a style="text-decoration: none; background: none; color: inherit;" href="/sms/public/teacher/student/list">
                    Danh sách học sinh
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
                <a style="text-decoration: none; background: none; color: inherit;" href="/sms/public/teacher/class/rate">
                    Đánh giá kết quả học
                </a>
            </div>
            <div class="enter-score">
                <a style="text-decoration: none; background: none; color: inherit;" href="/sms/public/teacher/class/enter/list">
                    Nhập điểm
                </a>
            </div>
            <div class="reportt">
                <a style="text-decoration: none; background: none; color: inherit;" href="/sms/public/teacher/class/record/list">
                    Báo cáo học lực lớp
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
    .enter-score,
    .reportt,
    .grade,
    .students,
    .conducts,
    .student-list,
    .student-payment,
    .reserved {
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
    .enter-score:hover,
    .reportt:hover,
    .conducts:hover,
    .student-list:hover,
    .student-payment:hover,
    .reserved:hover {
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