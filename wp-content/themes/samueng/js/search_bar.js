document.getElementById('apply-filters').addEventListener('click', function () {
    const searchQuery = document.getElementById('search-project').value.toLowerCase();
    const filterRating = document.getElementById('filter-rating').value;
    const sortOption = document.getElementById('sort-project').value;

    // Gửi yêu cầu AJAX đến server
    const params = new URLSearchParams({
        action: 'filter_projects',
        search: searchQuery,
        rating: filterRating,
        sort: sortOption,
    });

    fetch(`${ajaxurl}?${params.toString()}`)
        .then((response) => response.json())
        .then((data) => {
            console.log(data); // Kiểm tra phản hồi từ server
            const projectsContainer = document.querySelector('.all-projects');
            projectsContainer.innerHTML = data.html; // Cập nhật danh sách dự án
        })
        .catch((error) => console.error('Error:', error));
});