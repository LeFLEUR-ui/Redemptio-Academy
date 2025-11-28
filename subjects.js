// subjects.js

// Assumes data.js (subjectsData) and gradesheet.js (loadGradesheet) are loaded.

/**
 * Renders the main subject load table.
 */
function renderSubjectsTable() {
    const tbody = document.getElementById('subjects-table-body');
    if (!tbody) return;

    let html = '';

    subjectsData.forEach(subject => {
        // Note: loadGradesheet must be a globally accessible function (defined in gradesheet.js)
        const viewGradesLink = `javascript:void(0)" onclick="loadGradesheet(${subject.id})`;

        html += `
            <tr class="hover:bg-gray-50 transition duration-100">
                <td data-label="Academic Year" class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${subject.year}</td>
                <td data-label="Term No." class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${subject.term}</td>
                <td data-label="Course Code" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">${subject.code}</td>
                <td data-label="Subject" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">${subject.name}</td>
                <td data-label="Section" class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${subject.section}</td>
                <td data-label="No. of Students" class="px-6 py-4 text-center text-sm font-bold">${subject.students}</td>
                <td data-label="Actions" class="px-6 py-4 whitespace-nowrap text-sm">
                    <a href="${viewGradesLink}" class="text-ra-primary hover:text-blue-800 font-semibold transition duration-150 p-1 rounded-md hover:bg-blue-50">View Gradesheet</a>
                </td>
            </tr>
        `;
    });
    tbody.innerHTML = html;
}