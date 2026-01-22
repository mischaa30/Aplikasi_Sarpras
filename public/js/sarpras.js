document.addEventListener('DOMContentLoaded', function () {
    const parent = document.getElementById('parent');
    const child = document.getElementById('child');

    if (!parent || !child) return;

    parent.addEventListener('change', function () {
        const parentId = this.value;

        for (let option of child.options) {
            if (option.value === "") continue;

            option.style.display =
                option.dataset.parent === parentId
                    ? 'block'
                    : 'none';
        }

        child.value = "";
    });
});
