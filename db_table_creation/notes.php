<?php
// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "lithub_db");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// SQL query to create the notes table
$sql = "CREATE TABLE notes (
    note_id INT AUTO_INCREMENT PRIMARY KEY,
    subject VARCHAR(150) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    file_path VARCHAR(255) NOT NULL,
    uploaded_by INT NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (uploaded_by) REFERENCES users(user_id) ON DELETE CASCADE
)";

// Execute the query
if (mysqli_query($conn, $sql)) {
    echo 'Notes table created successfully';
} else {
    echo 'Error creating table: ' . mysqli_error($conn);
}

// Close the connection
mysqli_close($conn);
?>