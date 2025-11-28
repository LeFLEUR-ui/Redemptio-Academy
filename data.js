// data.js

/**
 * Subject Load Data.
 * @type {Array<Object>}
 */
const subjectsData = [
    {
        'id': 1,
        'year': '2025-2026',
        'term': '1st Term',
        'code': 'COSC1046',
        'name': 'Fundamentals of Web Programming',
        'section': 'BSCS501',
        'students': 38,
    },
    {
        'id': 2,
        'year': '2025-2026',
        'term': '1st Term',
        'code': 'MATH2001',
        'name': 'Calculus I',
        'section': 'BSED302',
        'students': 45,
    }
];

/**
 * Simulated student grades data (keyed by subject ID).
 * @type {Object<number, Array<Object>>}
 */
const allStudentsGrades = {
    1: [ // Subject ID 1
        {
            'student_no': '02000335526',
            'name': 'Fabricante, Marvin',
            'midterm_q1': 95,
            'midterm_a1': 95,
            'midterm_exam': 95,
            'finals_q1': 95,
            'finals_a1': 95,
            'finals_exam': 95,
        },
        {
            'student_no': '02000335527',
            'name': 'Dela Cruz, Juan',
            'midterm_q1': 88,
            'midterm_a1': 90,
            'midterm_exam': 85,
            'finals_q1': 92,
            'finals_a1': 89,
            'finals_exam': 90,
        }
    ],
    2: [ // Subject ID 2 (Sample data for the second subject)
        {
            'student_no': '02000441101',
            'name': 'Santos, Maria',
            'midterm_q1': 90,
            'midterm_a1': 85,
            'midterm_exam': 92,
            'finals_q1': 88,
            'finals_a1': 90,
            'finals_exam': 85,
        }
    ]
};

/**
 * Calculates the midterm, finals, and final grades.
 * @param {Object} grades - The object containing student's raw grades (e.g., midterm_q1).
 * @returns {Object} - Object with calculated 'midterm', 'finals', and 'final' grades.
 */
function calculate_final_grade(grades) {
    // Rounding function helper
    const round = Math.round;

    const midterm_grade = round((grades.midterm_q1 + grades.midterm_a1 + grades.midterm_exam) / 3);
    const finals_grade = round((grades.finals_q1 + grades.finals_a1 + grades.finals_exam) / 3);

    return {
        midterm: midterm_grade,
        finals: finals_grade,
        final: round((midterm_grade + finals_grade) / 2)
    };
}