import './bootstrap';
import 'simplebar';
import ClipboardJS from 'clipboard';
import { Tooltip, Toast, Popover, Alert, Tab, Modal } from 'bootstrap';
import Cookies from 'js-cookie'
import autoComplete from "@tarekraafat/autocomplete.js";
window.Tab = Tab
window.Modal = Modal
window.Tooltip = Tooltip

const ArtisanApp = function () {
    const clipboardCopy = function () {
        if (document.querySelectorAll('.copy-clipboard').length > 0) {
            document.querySelectorAll('.copy-clipboard').forEach(element => {
                let options = {}
                if (element.dataset.callback) {
                    options = {
                        text: window[element.dataset.callback]
                    }
                }
                const clipboard = new ClipboardJS(element, options);
                clipboard.on('success', (e) => {
                    let text = e.trigger.dataset.copied;
                    let old = e.trigger.getAttribute('data-bs-original-title');
                    const tooltip = Tooltip.getOrCreateInstance(e.trigger);
                    tooltip.setContent({ '.tooltip-inner': text });
                    setTimeout(function () {
                        tooltip.setContent({ '.tooltip-inner': old });
                    }, 2000);
                });
            });
        }
    },
        appBootstrap = function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new Tooltip(tooltipTriggerEl)
            })
        },
        appSignout = function () {
            if (document.querySelectorAll('.signoutBtn').length > 0) {
                document.querySelectorAll('.signoutBtn').forEach(button => {
                    button.addEventListener('click', e => {
                        document.querySelector('#signout-form').submit();
                    });
                });
            }
        },
        rangeSlider = function () {
            var slider = document.querySelectorAll('.range-slider');
            if (slider.length > 0) {
                slider.forEach(element => {
                    var range = element.querySelector('.range-slider__range'),
                        value = element.querySelector('.range-slider__value');
                    value.innerHTML = value.previousElementSibling.value
                    range.addEventListener('input', e => {
                        value.innerHTML = e.target.value
                    })
                });
            }
        },
        showLoaderOnSubmit = function () {
            if (document.querySelectorAll('form').length > 0) {
                document.querySelectorAll('form').forEach(element => {
                    if (!element.classList.contains('no-app-loader')) {
                        element.addEventListener('submit', e => {
                            ArtisanApp.showLoader()
                        })
                    }
                });
            }
        },
        updateFavouriteTool = function () {
            if (document.querySelectorAll('.add-favorite-btn').length > 0) {
                document.querySelectorAll('.add-favorite-btn').forEach(element => {
                    element.addEventListener('click', e => {
                        ArtisanApp.showLoader()
                        var dataSet = element.dataset;
                        axios.post(
                            dataSet.url, {
                            id: dataSet.id
                        })
                            .then((res) => {
                                ArtisanApp.hideLoader()
                                if (res.data.success === true) {
                                    element.classList.toggle('active');
                                }
                                ArtisanApp.toastSuccess(res.data.message);
                            })
                            .catch((err) => {
                                ArtisanApp.hideLoader()
                                ArtisanApp.toastError(err);
                            })
                    })
                });
            }
        },
        initSearch = function () {
            const route = document.querySelector('meta[name="app-search"]') ? document.querySelector('meta[name="app-search"]').content : null;
            if (document.querySelector('#toolsAutocomplete') && route) {
                const myDropdown = document.querySelector('.header-search-nav')
                const ACfield = document.querySelector('#toolsAutocomplete')
                myDropdown.addEventListener('shown.bs.dropdown', function () {
                    ACfield.focus()
                })
                myDropdown.addEventListener('hidden.bs.dropdown', function () {
                    ACfield.value = null
                })
                const config = {
                    selector: "#toolsAutocomplete",
                    data: {
                        src: async (query) => {
                            return await axios.get(route, {
                                params: {
                                    q: query
                                }
                            }).then(res => {
                                return res.data
                            }).catch(err => {
                                return err
                            });
                        },
                        keys: ["name"],
                        cache: true,
                    },
                    resultsList: {
                        element: (list, data) => {
                            if (!data.results.length) {
                                const message = document.createElement("div");
                                message.setAttribute("class", "no_result text-muted text-center py-3");
                                message.innerHTML = `<span>Found No Results for "${data.query}"</span>`;
                                list.prepend(message);
                            }
                        },
                        noResults: true,
                    },
                    resultItem: {
                        highlight: true
                    },
                    events: {
                        input: {
                            selection: (event) => {
                                const selection = event.detail.selection.value;
                                if (selection.url) {
                                    window.location = selection.url;
                                }
                            }
                        }
                    }
                };
                new autoComplete(config);
            }
        },
        initBackToTop = function () {
            var toTopButton = document.getElementById("to-top-button");
            if (toTopButton) {
                window.onscroll = function () {
                    if (document.body.scrollTop > 500 || document.documentElement.scrollTop > 500) {
                        toTopButton.classList.remove("invisible");
                    } else {
                        toTopButton.classList.add("invisible");
                    }
                }
                toTopButton.addEventListener('click', function (e) {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                })
            }
        },
        adblockDetection = function () {
            const blockerWrapper = document.querySelector('#mta-blocked-wrapper')
            if (!blockerWrapper) {
                return;
            }
            const blockerButton = blockerWrapper.querySelector('.mta-blocked-button')
            const wrapper = document.querySelector('.main-wrapper')
            const adblockTests = {
                uBlockOrigin: {
                    url: '/data/yzfdmoan.js',
                    id: '837jlaBksSjd9jh',
                },
                adblockPlus: {
                    url: '/data/utep_ad.js',
                    id: 'hfuBadsf3hFAk',
                },
                adsense: {
                    url: 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js',
                    id: 'aBksSadsf3jd9'
                }
            };

            function canLoadRemoteScript(obj) {
                return new Promise(function (resolve, reject) {
                    var script = document.createElement('script');
                    script.onload = function (e) {
                        if (document.getElementById(obj.id)) {
                            resolve(false);
                        } else {
                            resolve(true);
                        }
                    }
                    script.onerror = function (e) {
                        resolve(true);
                    }
                    script.src = obj.url;
                    script.id = obj.id
                    document.body.appendChild(script);
                });
            }

            new Promise(function (resolve, reject) {
                let promises = [
                    canLoadRemoteScript(adblockTests.adsense),
                ];

                Promise.all(promises).then((results) => {
                    resolve({
                        adsense: results[0],
                        usingAdblock: (results[0] === true),
                    });
                }).catch((err) => {
                    reject(err);
                });
            }).then((res) => {
                if (res.usingAdblock) {
                    blockerWrapper.classList.remove('d-none')
                    wrapper.style.filter = 'blur(4px)';
                    document.querySelector('body').style.overflow = 'hidden'
                    blockerButton.addEventListener('click', () => {
                        location.reload();
                    })
                }
            });
        };

    return {
        init: function () {
            adblockDetection();
            appSignout();
            initSearch();
            rangeSlider();
            clipboardCopy();
            appBootstrap();
            showLoaderOnSubmit();
            updateFavouriteTool();
            initBackToTop();
            this.hideLoader();
            this.scrollToResults();
            this.initDarkMode();
            this.initToast();
        },
        scrollToResults: function () {
            if (document.querySelector('.tool-results-wrapper')) {
                document.querySelector(".tool-results-wrapper").scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        },
        showLoader: function () {
            if (document.querySelector('#app-loader')) {
                document.querySelector('#app-loader').classList.remove('d-none')
            }
        },
        hideLoader: function () {
            if (document.querySelector('#app-loader')) {
                document.querySelector('#app-loader').classList.add('d-none')
            }
        },
        initUpload: function (uploader, { filesGrid = null, maxFiles = 1, maxSize = null, fileExtensions = null, dropOnBody = false, fileSelectedCallback = false }, { extensionsError, sizeError, filesError }) {
            let filesList = [];
            const fileSelect = uploader.querySelector('[type=file]');
            const uploaderDrag = uploader.querySelector('label.file-drag');
            const fileDrag = dropOnBody ? document.body : uploaderDrag;
            const uploadWrapper = uploader.querySelector('.uploader-wrapper')

            fileSelect.addEventListener('change', fileSelectHandler, false);
            var xhr = new XMLHttpRequest();
            if (xhr.upload) {
                fileDrag.addEventListener('dragover', fileDragHover, false);
                fileDrag.addEventListener('dragleave', fileDragHover, false);
                fileDrag.addEventListener('drop', fileSelectHandler, false);
            }

            function fileDragHover(event) {
                event.stopPropagation();
                event.preventDefault();

                event.type === 'dragover' ? uploaderDrag.classList.add('hover') : uploaderDrag.classList.remove('hover');
            }

            function fileSelectHandler(e) {
                fileDragHover(e);
                var files = e.target.files || e.dataTransfer.files;
                ([...files]).forEach(file => {
                    parseFile(file);
                });

                if (typeof window[fileSelectedCallback] == 'function' && filesList.length > 0) {
                    window[fileSelectedCallback](filesList)
                }

                updateFileList();
            }

            // function output(filesPreview, file, index) {
            //     const src = URL.createObjectURL(file)
            //     const fileSize = ArtisanApp.humanFileSize(file.size)
            //     var div = document.createElement('div');
            //     div.className = `grid-item grid-item-${index}`
            //     div.bsToggle = 'tooltip'
            //     div.title = file.name
            //     div.innerHTML = `<div class="item-image">
            //                         <img src="${src}" />
            //                         <button type="button" class="btn btn-danger rounded-pill delete-item"></button>
            //                     </div>
            //                     <div class="content">
            //                         <p>${file.name}</p>
            //                         <span>${fileSize}</span>
            //                     </div>`
            //     div.querySelector('.delete-item').addEventListener('click', () => {
            //         deleteFile(index)
            //     })
            //     filesPreview.appendChild(div);
            //     new Tooltip(div, {})
            // }
            function output(filesPreview, file, index) {
                const src = URL.createObjectURL(file);
                const fileSize = ArtisanApp.humanFileSize(file.size);
                var div = document.createElement('div');
                div.className = `grid-item grid-item-${index}`;
                div.bsToggle = 'tooltip';
                div.title = file.name;

                // Check the file type and create the appropriate media element
                let mediaElement;
                if (file.type.startsWith('image/')) {
                    mediaElement = `<img src="${src}" />`;
                } else if (file.type.startsWith('video/')) {
                    mediaElement = `<video src="${src}" controls></video>`;
                } else {
                    const fileName = file.name;
                    const fileExtension = fileName.split('.').pop().toLowerCase();
                    if (fileExtension === 'heic' || fileExtension === 'avif') {
                        mediaElement = `<div class="image-preview-placeholder h-100 w-100 bg-white d-flex align-items-center justify-content-center display-1 text-muted"><i class="an an-image"></i></div>`;
                    } else {
                        mediaElement = `<p>Unsupported file type</p>`;
                    }
                }

                div.innerHTML = `
                            <div class="item-image">
                                ${mediaElement}
                                <button type="button" class="btn btn-danger rounded-pill delete-item"></button>
                            </div>
                            <div class="content">
                                <p>${file.name}</p>
                                <span>${fileSize}</span>
                            </div>`;

                div.querySelector('.delete-item').addEventListener('click', () => {
                    deleteFile(index);
                });
                filesPreview.appendChild(div);
                new Tooltip(div, {});
            }

            function updateFileList() {
                if (!filesGrid) {
                    if (filesList.length == 0) {
                        uploadWrapper.classList.remove('d-none')
                        uploader.querySelector('.add-more')?.classList.add("d-none");
                        uploader.querySelector('.uploader-after > .process-button')?.classList.add('d-none');
                    } else {
                        uploadWrapper.classList.add('d-none');
                        uploader.querySelector('.uploader-after > .process-button')?.classList.remove('d-none');
                    }
                }

                const filesPreview = !filesGrid ? uploader.querySelector('.files-grid') : document.querySelector(filesGrid)
                filesPreview.innerHTML = ''
                const dataTransfer = new DataTransfer()
                filesList.forEach((file, index) => {
                    output(filesPreview, file, index)
                    dataTransfer.items.add(file)
                });

                fileSelect.files = dataTransfer.files
            }

            function deleteFile(index) {
                Tooltip.getInstance(document.querySelector(`.grid-item-${index}`)).dispose()
                filesList.splice(index, 1)
                updateFileList()
            }

            function parseFile(file) {
                if (validation(file)) {
                    uploader.querySelector('.uploader-wrapper').classList.add("d-none");
                    uploader.querySelector('.uploader-error')?.classList.add("d-none");
                    if (maxFiles == 1) {
                        filesList = [file]
                    } else if (validateMaxFiles(file)) {
                        uploader.querySelector('.add-more')?.classList.remove("d-none");
                        filesList.push(file)
                    }
                } else {
                    uploader.querySelector('.uploader-error')?.classList.remove("d-none");
                    uploader.querySelector('label.file-drag').classList.remove("d-none");
                }
            }

            function validation(file) {
                return validateExtensions(file) && validateSize(file)
            }

            function validateExtensions(file) {
                var imageName = file.name;
                const regex = new RegExp(`(?=${fileExtensions})`, 'gi')
                const state = !fileExtensions || regex.test(imageName);
                if (!state) {
                    ArtisanApp.toastError(extensionsError)
                }

                return state
            }

            function validateSize(file) {
                const state = !maxSize || file.size <= maxSize * 1024 * 1024
                if (!state) {
                    ArtisanApp.toastError(sizeError)
                }

                return state;
            }

            function validateMaxFiles() {
                const state = !maxFiles || filesList.length < maxFiles;
                if (!state) {
                    ArtisanApp.toastError(filesError)
                }

                return state
            }
        },
        initDarkMode: function () {
            if (!document.querySelector('.btn-mode')) {
                return;
            }
            var button = document.querySelector('.btn-mode');
            var themeMode = document.querySelector('.theme-mode');
            button.addEventListener('click', function () {
                if (themeMode.classList.contains('theme-mode-dark')) {
                    themeMode.classList.remove('theme-mode-dark')
                    themeMode.classList.add('theme-mode-light');
                } else {
                    themeMode.classList.add('theme-mode-dark')
                    themeMode.classList.remove('theme-mode-light');
                }
            });

            // change darkmode
            const STORAGE_KEY = 'siteMode';
            const modeToggleButton = document.querySelector('.js-mode-toggle');

            const applySetting = passedSetting => {
                let currentSetting = passedSetting || Cookies.get(STORAGE_KEY);
                if (currentSetting) {
                    document.documentElement.setAttribute('theme-mode', currentSetting);
                }
            };

            const toggleSetting = () => {
                let currentSetting = Cookies.get(STORAGE_KEY) === 'dark' ? 'light' : 'dark';
                Cookies.set('siteMode', currentSetting)
                return currentSetting;
            };
            modeToggleButton.addEventListener('click', evt => {
                evt.preventDefault();
                applySetting(toggleSetting());
            });
            applySetting();
        },
        humanFileSize: function (size) {
            var i = size == 0 ? 0 : Math.floor(Math.log(size) / Math.log(1024));
            return (size / Math.pow(1024, i)).toFixed(2) * 1 + ' ' + ['B', 'kB', 'MB', 'GB', 'TB'][i];
        },
        toastError: function (message) {
            const html = `<div class="toast toast-danger" role="alert" aria-live="assertive" data-bs-delay="3000" aria-atomic="true" data-bs-autohide="true">
                            <div class="d-flex">
                                <div class="toast-body">${message}</div>
                                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                        </div>`;
            this.appendToast(html)
        },
        toastSuccess: function (message) {
            const html = `<div class="toast toast-success" role="alert" aria-live="assertive" data-bs-delay="3000" aria-atomic="true" data-bs-autohide="true">
                            <div class="d-flex">
                                <div class="toast-body">${message}</div>
                                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                        </div>`;
            this.appendToast(html)
        },
        appendToast: function (html) {
            if (!document.querySelector('.toast-container')) return;
            var child = document.createElement('div');
            child.innerHTML = html;
            child = child.firstChild;

            document.querySelector('.toast-container').prepend(child)
            this.initToast();
        },
        initToast: function () {
            var toastElList = [].slice.call(document.querySelectorAll('.toast-container .toast'))
            toastElList.map(function (toastEl) {
                toastEl.addEventListener('hidden.bs.toast', function () {
                    toastEl.remove()
                })
                const toast = new Toast(toastEl, { autohide: true })
                toast.show()
            })
        },
        printResult: function (target, { title = null, header_code = null }) {
            title = title ? title : document.title
            const printIframe = document.createElement('iframe');
            printIframe.name = "printIframe";
            printIframe.style.position = "absolute";
            printIframe.style.top = "-1000000px";
            document.body.appendChild(printIframe);
            const print = (printIframe.contentWindow) ? printIframe.contentWindow : (printIframe.contentDocument.document) ? printIframe.contentDocument.document : printIframe.contentDocument;
            print.document.open();
            print.document.write(`<html><head><title>${title}</title>${header_code}`);
            print.document.write('<style>abbr[title]::after{content:" (" attr(title) ")"}.pagebreak{page-break-after:always;}pre{white-space:pre-wrap!important}blockquote,pre{border:1px solid #adb5bd;page-break-inside:avoid}img,tr{page-break-inside:avoid}h2,h3,p{orphans:3;widows:3}h2,h3{page-break-after:avoid}@page{size:a3}body{min-width:992px!important}.container{min-width:992px!important}.table{border-collapse:collapse!important}.table td,.table th{background-color:#fff!important}.table-bordered td,.table-bordered th{border:1px solid #dee2e6!important}.table-dark{color:inherit}.table-dark tbody+tbody,.table-dark td,.table-dark th,.table-dark thead th{border-color:#dee2e6}.d-print-none{display:none;}</style></head><body style="background-color:#fff;">');
            print.document.write(target.innerHTML);
            print.document.write('</body></html>');
            print.document.close();
            setTimeout(function () {
                window.frames["printIframe"].focus();
                window.frames["printIframe"].print();
                document.body.removeChild(printIframe);
            }, 500);

            return false;
        },
        downloadAsTxt: function (elementOrText, { isElement = true, filename = null, fileMime = 'text/plain', fileType = null }) {
            const text = isElement ? document.querySelector(elementOrText)?.value : elementOrText;
            if (!text) {
                return;
            }

            if (!filename) {
                filename = Number(new Date()) + (fileType ? `.${fileType}` : '.txt');
            }

            var element = document.createElement('a');
            element.setAttribute('href', `data:${fileMime};charset=utf-8,` + encodeURIComponent(text));
            element.setAttribute('download', filename);
            element.style.display = 'none';
            document.body.appendChild(element);
            element.click();
            document.body.removeChild(element);
        },
        downloadFromUrl(url, fileName) {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", url, true);
            xhr.responseType = "blob";
            xhr.onload = function () {
                var urlCreator = window.URL || window.webkitURL;
                var imageUrl = urlCreator.createObjectURL(this.response);
                var element = document.createElement('a');
                element.href = imageUrl;
                element.download = fileName;
                document.body.appendChild(element);
                element.click();
                document.body.removeChild(element);
            }
            xhr.send();
        },
        isJson: function (str) {
            try {
                JSON.parse(str);
            } catch (e) {
                return false;
            }
            return true;
        },
        checkDailyUsage: function ($limit, $usage) {
            try {
                if ($limit <= $usage) {
                    return false;
                }
            } catch (e) {
                return false;
            }
            return true;
        }
    }
}();

window.ArtisanApp = ArtisanApp
window.ClipboardJS = ClipboardJS
document.addEventListener("DOMContentLoaded", function (event) {
    ArtisanApp.init();
});

