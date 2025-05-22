
let currentFieldId = null;
const editModalEl = document.getElementById('editModal');
const editModal = new bootstrap.Modal(editModalEl);

document.querySelectorAll('.edit-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    currentFieldId = btn.dataset.target;
    const input = document.getElementById(currentFieldId);
    const labelText = document.querySelector(`label[for="${currentFieldId}"]`).innerText;

    document.getElementById('editModalLabel').innerText = `Cambiar ${labelText}`;
    const newValue = document.getElementById('newValue');
    newValue.value = '';
    newValue.type = input.type === 'password' ? 'password' : 'text';
    newValue.placeholder = input.placeholder;

    document.getElementById('currentPassword').classList.remove('is-invalid');
    editModal.show();
  });
});

document.getElementById('confirmEdit').addEventListener('click', () => {
  const pwdInput = document.getElementById('currentPassword');
  const newValue = document.getElementById('newValue').value.trim();

  if (!pwdInput.value.trim()) {
    pwdInput.classList.add('is-invalid');
    return;
  }

  document.getElementById(currentFieldId).value = newValue;
  editModal.hide();
  pwdInput.value = '';
});
