<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .footer {
            margin-top: 20px;
            text-align: right;
        }
    </style>
</head>

<body>
    <h1>{{ $title }}</h1>
    <p>Generated on: {{ $date }}</p>

    <table>
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Grade Level</th>
                <th>Strand</th>
                <th>Track</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $student)
            <tr>
                <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                <td>{{ $student->grade_level ?? 'N/A' }}</td>
                <td>{{ $student->strand->name ?? 'N/A' }}</td>
                <td>{{ $student->track->name ?? 'N/A' }}</td>
                <td>{{ $student->status ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>SHS Student Enrollment System</p>
    </div>
</body>

</html>