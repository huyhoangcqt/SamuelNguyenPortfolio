document.addEventListener("DOMContentLoaded", function () {
    const labels = document.querySelectorAll(".item-collapse-label");

    labels.forEach((label) => {
        label.addEventListener("click", function () {
            const isActive = this.classList.contains("active");

            // Tìm container cha (collapse-group)
            const parentGroup = this.closest(".collapse-group");

            // Đóng tất cả các collapse khác trong cùng container cha
            parentGroup.querySelectorAll(".item-collapse-label.active").forEach((activeLabel) => {
                if (activeLabel !== this) {
                    activeLabel.classList.remove("active");
                    activeLabel.nextElementSibling.style.display = "none";
                }
            });

            // Toggle trạng thái hiện tại
            if (!isActive) {
                this.classList.add("active");
                this.nextElementSibling.style.display = "block";
            } else {
                this.classList.remove("active");
                this.nextElementSibling.style.display = "none";
            }
        });
    });
});