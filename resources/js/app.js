import "./bootstrap";

const zipCodeUrl = (zipCode) =>
    `https://viacep.com.br/ws/${zipCode.replace(/\D+/gm, "")}/json`;

const getZipCodeData = async (zipCode) => await axios.get(zipCodeUrl(zipCode));

const element = (selector) => document.querySelector(selector);
const elements = (selector) => document.querySelectorAll(selector);

const zipCodeElement = element("#zip_code");

const updateFormData = async () => {
    const value = zipCodeElement.value;
    if (value.replace(/\D+/gm, "").length >= 8) {
        await getZipCodeData(value)
            .then((res) => {
                const { data } = res;
                if (data.logradouro) {
                    element("#address").value = data.logradouro;
                }
                if (data.bairro) element("#neighborhood").value = data.bairro;
                if (data.localidade) element("#city").value = data.localidade;
                if (data.uf) element("#state").value = data.uf;
            })
            .catch((err) => console.log(err.message));
    }
};

if (zipCodeElement) {
    zipCodeElement.addEventListener(
        "keyup",
        async () => await updateFormData()
    );

    zipCodeElement.addEventListener(
        "change",
        async () => await updateFormData()
    );
}

element("#addRoom").addEventListener("click", (event) => {});

elements(".form-delete").forEach((element) => {
    element.addEventListener("submit", (event) => {
        event.preventDefault();
        swal.fire({
            title: "Question",
            text: "Do you delete this record?",
            icon: "question",
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonText: "Ok",
            cancelButtonText: "Cancel",
        }).then(({ isConfirmed }) => {
            if (isConfirmed) element.submit();
        });
    });
});
