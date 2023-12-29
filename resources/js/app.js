import "./bootstrap";
import axios from "axios";
import Swal from "sweetalert2";

axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

const getData = async (url, params = {}) =>
    await axios({
        url,
        method: "get",
        params,
    });

const postData = async (url, data = {}) => {
    const csrf = element('meta[name="csrf-token"]');
    return await axios({
        url,
        method: "post",
        headers: { "X-CSRF-TOKEN": csrf.content },
        data,
    });
};

const putData = async (url, data = {}) => {
    const csrf = element('meta[name="csrf-token"]');
    return await axios({
        url,
        method: "post",
        headers: { "X-CSRF-TOKEN": csrf.content },
        data: {
            ...data,
            _method: "PUT",
        },
    });
};

const deleteData = async (url, data = {}) => {
    const csrf = element('meta[name="csrf-token"]');
    return await axios({
        url,
        method: "post",
        headers: { "X-CSRF-TOKEN": csrf.content },
        data: {
            ...data,
            _method: "DELETE",
        },
    });
};

const parseZipCodeUrl = (code) =>
    `https://viacep.com.br/ws/${code.replace(/\D+/gm, "")}/json`;

const element = (selector) => document.querySelector(selector);
const elements = (selector) => document.querySelectorAll(selector);

const zipCodeElement = element("#zip_code");

const updateFormData = async () => {
    const value = zipCodeElement.value;
    if (value.replace(/\D+/gm, "").length >= 8) {
        await getData(parseZipCodeUrl(value))
            .then((res) => {
                const { data } = res;
                if (data.logradouro) {
                    element("#address").value = data.logradouro;
                }
                if (data.bairro) element("#neighborhood").value = data.bairro;
                if (data.localidade) element("#city").value = data.localidade;
                if (data.uf) element("#state").value = data.uf;
            })
            .catch((err) =>
                console.log(err?.response?.data?.message || err.message)
            );
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

window.deleteRoom = (el) => {
    const roomsList = element("#roomsList");

    Swal.fire({
        title: $t("lang.question"),
        text: $t("lang.delete_record_confirm"),
        icon: "question",
        showConfirmButton: true,
        showCancelButton: true,
        confirmButtonText: $t("lang.yes"),
        cancelButtonText: $t("lang.no"),
    }).then(({ isConfirmed }) => {
        if (isConfirmed) {
            el.parentElement.parentElement.remove();
            const rooms = elements("#roomsList > tr");
            if (rooms.length === 0) {
                const row = document.createElement("tr");
                row.id = "noRoom";
                row.classList =
                    "bg-white border-b dark:bg-gray-800 dark:border-gray-700";

                const c1 = document.createElement("td");
                c1.colSpan = 3;
                c1.classList =
                    "px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap";
                c1.innerText = $t("lang.no_records_arg", {
                    arg: $t("lang.room").toLowerCase(),
                });

                row.appendChild(c1);

                roomsList.appendChild(row);
            }
        }
    });
};

const addRoom = element("#addRoom");

if (addRoom) {
    addRoom.addEventListener("click", () => {
        const roomsList = element("#roomsList");
        const noRoom = element("#noRoom");

        if (noRoom) noRoom.remove();

        const rooms = elements("#roomsList > tr");
        const index = rooms.length;

        const tdClasses =
            "px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap";

        const row = document.createElement("tr");
        row.classList =
            "bg-white border-b dark:bg-gray-800 dark:border-gray-700";

        const c1 = document.createElement("td");
        const c2 = document.createElement("td");
        const c3 = document.createElement("td");

        c1.classList = tdClasses;
        c2.classList = tdClasses;
        c3.classList = "px-6 py-4 w-44 items-center";

        c1.innerHTML = `<input class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" type="text" name="rooms[${index}][name]" placeholder="${$t(
            "lang.name"
        )}">`;
        c2.innerHTML = `<input class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" type="text" name="rooms[${index}][description]" placeholder="${$t(
            "lang.description"
        )}">`;
        c3.innerHTML = `<button type="button" onclick="window.deleteRoom(this);" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" title="${$t(
            "lang.delete_arg",
            { arg: $t("lang.room").toLowerCase() }
        )}">
    <svg class="w-4 h-4 text-gray-300 dark:text-gray-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"></path>
    </svg>
    </button>`;

        row.appendChild(c1);
        row.appendChild(c2);
        row.appendChild(c3);

        roomsList.appendChild(row);
    });
}

const checkIfThereAreNoRooms = () => {
    const roomsList = element("#roomsList");
    const rooms = elements("#roomsList > tr");
    if (rooms.length === 0) {
        const row = document.createElement("tr");
        row.classList =
            "bg-white border-b dark:bg-gray-800 dark:border-gray-700";

        const c1 = document.createElement("td");
        c1.id = "noRoom";
        c1.classList =
            "px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap";
        c1.colSpan = 3;
        c1.innerText = $t("lang.no_records_arg", {
            arg: $t("lang.room").toLowerCase(),
        });

        row.appendChild(c1);

        roomsList.appendChild(row);
    }
};

const deleteRoomListener = () => {
    elements(".delete-room").forEach((el) => {
        el.removeEventListener("click", () => null);
        el.addEventListener("click", async () => {
            const url = el.dataset.deleteUrl;
            Swal.fire({
                title: $t("lang.question"),
                text: $t("lang.delete_record_confirm"),
                icon: "question",
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: $t("lang.yes"),
                cancelButtonText: $t("lang.no"),
            }).then(async ({ isConfirmed }) => {
                if (isConfirmed) {
                    await deleteData(url)
                        .then(({ data }) => {
                            element("#roomsList").innerHTML = "";
                            if (data.length) {
                                for (const item of data) {
                                    renderDataRow(item);
                                }
                            }
                            checkIfThereAreNoRooms();
                        })
                        .catch((err) =>
                            Swal.fire({
                                title: $t("lang.error"),
                                text:
                                    err?.response?.data?.message || err.message,
                                icon: "error",
                                confirmButtonText: $t("lang.ok"),
                            })
                        );
                }
            });
        });
    });
};

window.saveRoom = async (el, url) => {
    const parent = el.parentElement.parentElement;
    const inputs = parent.querySelectorAll("input");
    const rawData = {};
    inputs.forEach((input) => (rawData[input.name] = input.value));

    await putData(url, {
        name: rawData.roomName,
        description: rawData.roomDescription,
    })
        .then(({ data }) => {
            parent.innerHTML = "";
            renderDataRow(data, parent);
        })
        .catch((err) =>
            Swal.fire({
                title: $t("lang.error"),
                text: err?.response?.data?.message || err.message,
                icon: "error",
                confirmButtonText: $t("lang.ok"),
            })
        );
};

const updateRoomListener = () => {
    const noRoom = element("#noRoom");
    elements(".update-room").forEach((el) => {
        el.removeEventListener("click", () => null);
        el.addEventListener("click", async () => {
            const editUrl = el.dataset.editUrl;
            const updateUrl = el.dataset.updateUrl;
            await getData(editUrl)
                .then(({ data }) => {
                    if (data) {
                        if (noRoom) noRoom.remove();
                        const row = el.parentElement.parentElement;
                        const cols = row.querySelectorAll("td");
                        cols.forEach((col) => col.remove());
                        row.classList =
                            "bg-white border-b dark:bg-gray-800 dark:border-gray-700 room-data";

                        const tdClasses =
                            "px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap";

                        const c1 = document.createElement("td");
                        const c2 = document.createElement("td");
                        const c3 = document.createElement("td");

                        c1.classList = tdClasses;
                        c2.classList = tdClasses;
                        c3.classList = "px-6 py-4 w-44 items-center";

                        c1.innerHTML = `<input class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" type="text" name="roomName" placeholder="${$t(
                            "lang.name"
                        )}" value="${data.name !== null ? data.name : ""}">`;
                        c2.innerHTML = `<input class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" type="text" name="roomDescription" placeholder="${$t(
                            "lang.description"
                        )}" value="${
                            data.description !== null ? data.description : ""
                        }">`;
                        c3.innerHTML = `<button type="button" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" title="${$t(
                            "lang.save_arg",
                            { arg: $t("lang.room").toLowerCase() }
                        )}" onclick="window.saveRoom(this, '${updateUrl}');">
                        <svg class="w-4 h-4" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M433.941 129.941l-83.882-83.882A48 48 0 0 0 316.118 32H48C21.49 32 0 53.49 0 80v352c0 26.51 21.49 48 48 48h352c26.51 0 48-21.49 48-48V163.882a48 48 0 0 0-14.059-33.941zM272 80v80H144V80h128zm122 352H54a6 6 0 0 1-6-6V86a6 6 0 0 1 6-6h42v104c0 13.255 10.745 24 24 24h176c13.255 0 24-10.745 24-24V83.882l78.243 78.243a6 6 0 0 1 1.757 4.243V426a6 6 0 0 1-6 6zM224 232c-48.523 0-88 39.477-88 88s39.477 88 88 88 88-39.477 88-88-39.477-88-88-88zm0 128c-22.056 0-40-17.944-40-40s17.944-40 40-40 40 17.944 40 40-17.944 40-40 40z"></path></svg>
                        </button>
                        `;

                        row.appendChild(c1);
                        row.appendChild(c2);
                        row.appendChild(c3);
                    }
                })
                .catch((err) =>
                    Swal.fire({
                        title: $t("lang.error"),
                        text: err?.response?.data?.message || err.message,
                        icon: "error",
                        confirmButtonText: $t("lang.ok"),
                    })
                );
            checkIfThereAreNoRooms();
        });
    });
};

deleteRoomListener();
updateRoomListener();

const renderDataRow = (data, parent) => {
    const url = `${location.protocol}//${location.host}`;
    const roomsList = element("#roomsList");
    const row = parent || document.createElement("tr");
    row.classList =
        "bg-white border-b dark:bg-gray-800 dark:border-gray-700 room-data";

    const tdClasses =
        "px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap";

    const c1 = document.createElement("td");
    const c2 = document.createElement("td");
    const c3 = document.createElement("td");

    c1.classList = tdClasses;
    c2.classList = tdClasses;
    c3.classList = "px-6 py-4 w-44 items-center";

    c1.innerText = data.name;
    c2.innerText = data.description;
    c3.innerHTML = `<button type="button" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition dark:bg-gray-600 update-room" data-edit-url="${url}/rooms/${
        data.id
    }/edit" data-update-url="${url}/rooms/${data.id}" title="${$t(
        "lang.edit_arg",
        { arg: $t("lang.room").toLowerCase() }
    )}">
<svg class="w-4 h-4 text-gray-300 dark:text-gray-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"></path>
    </svg>
</button>
<button type="button" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 delete-room" data-delete-url="${url}/rooms/${
        data.id
    }" title="${$t("lang.delete_arg", { arg: $t("lang.room").toLowerCase() })}">
    <svg class="w-4 h-4 text-gray-300 dark:text-gray-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"></path>
</svg>
</button>`;

    row.appendChild(c1);
    row.appendChild(c2);
    row.appendChild(c3);

    if (!parent) roomsList.appendChild(row);

    deleteRoomListener();
    updateRoomListener();
};

elements(".form-delete").forEach((element) => {
    element.addEventListener("submit", (event) => {
        event.preventDefault();
        Swal.fire({
            title: $t("lang.question"),
            text: $t("lang.delete_record_confirm"),
            icon: "question",
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonText: $t("lang.yes"),
            cancelButtonText: $t("lang.no"),
        }).then(({ isConfirmed }) => {
            if (isConfirmed) element.submit();
        });
    });
});
