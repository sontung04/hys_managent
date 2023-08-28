<h2>Thông báo cho {{ $student_name }} đóng học phí cho khóa:

<ul>
    @foreach ($course_names as $index => $course_name)
        <li>
            {{ $course_name }} với số tiền {{ number_format($monies[$index]) }} VND.
        </li>
    @endforeach
</ul>

</h2>
