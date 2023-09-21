@props([
    'field' => $attributes->wire('model')->value(),
    'maxFileSize' => 20,
    'showNotification' => true,
    'multiple' => false,
    'name' => $attributes->get('name'),
    'fileTypes' => [
        'application/pdf',
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'image/png',
        'image/jpeg',
    ],
    'fileTypesLabel' => 'png, jpg, pdf, xls, xlsx, doc или docx'
])

<div
    wire:ignore
    x-data="{
        pond: null,
        field: @toJs($field),
        maxFileSize: @toJs($maxFileSize),
        showNotification: @toJs($showNotification),
        multiple: @boolean($multiple),
        name: @toJs($name),
        fileTypes: @toJs($fileTypes),
        fileTypesLabel: @toJs($fileTypesLabel),
    }"
    x-init="
        pond = Filepond.create($refs.input);
        pond.setOptions({
            labelIdle: '<div class=\'cursor-pointer hidden sm:block\'><span class=\'link\'>Выберите файл</span> или перетащите сюда</div> <div class=\'cursor-pointer block sm:hidden link\'>Загрузить файлы</div>',
            labelInvalidField: 'Загруженный файл не соответствует требованиям',
            labelFileLoading: 'Загрузка',
            labelFileLoadError: 'Ошибка при загрузке',
            labelFileProcessing: 'Загрузка',
            labelFileProcessingComplete: 'Загрузка завершена',
            labelFileProcessingAborted: 'Загрузка отменена',
            labelFileProcessingError: 'Ошибка при загрузке',
            labelFileProcessingRevertError: 'Ошибка при отмене загрузки',
            labelFileRemoveError: 'Ошибка при удалении',
            labelTapToCancel: 'нажмите, чтобы отменить',
            labelTapToRetry: 'нажмите, чтобы повторить',
            labelTapToUndo: 'нажмите, чтобы отменить',
            labelButtonRemoveItem: 'Удалить',
            labelButtonAbortItemLoad: 'Отменить',
            labelButtonRetryItemLoad: 'Повторить',
            labelButtonAbortItemProcessing: 'Отменить',
            labelButtonUndoItemProcessing: 'Отменить',
            labelButtonRetryItemProcessing: 'Повторить',
            labelButtonProcessItem: 'Загрузить',
            allowMultiple: multiple,
            fileValidateTypeDetectType: (source, type) => {
                const p = new Promise((resolve, reject) => {
                    if ((source.name.toLowerCase().indexOf('.sig') !== -1) || (source.name.toLowerCase().indexOf('.sgn') !== -1)) {
                        resolve('application/sig')
                    } else {
                        resolve(type)
                    }
                })

                return p
            },
            labelFileTypeNotAllowed: 'Неверный тип файла',
            fileValidateTypeLabelExpectedTypes: 'Ожидаются ' + fileTypesLabel,
            acceptedFileTypes: fileTypes,
            labelMaxFileSizeExceeded: 'Файл слишком большой',
            labelMaxFileSize: 'Максимальный размер файла: ' + maxFileSize + ' MB',
            onprocessfiles: () => Livewire.emit('enableBtn'),
            onerror: (error, attachment) => {
               if (showNotification) {
                   window.$wireui.notify({
                       icon: 'error',
                       title: 'Ошибка загрузки!',
                       description: `Файл: <b>${attachment.file.name}</b> не будет загружен по причине: <b>${error.main}</b>`
                   })
               }
            },
            onupdatefiles: (files) => files.length > 0 ? Livewire.emit('disableBtn') : Livewire.emit('enableBtn'),
            server: {
                process: (fieldName, file, metadata, load, error, progress, abort, transfer, options ) => {
                    @this.upload(field, file, load, error, progress)
                },
                revert:  (filename, load) => {
                    @this.removeUpload(field, filename, load)
                }
            },
            maxFileSize: maxFileSize * 1024 * 1024
        });
        if (name) {
            window.addEventListener(name + '-reset', () => {
                pond.removeFiles();
            });
        }

        // Можно очищать скисок загруженных файлов так: $this->dispatchBrowserEvent('pondReset');
        this.addEventListener('pondReset', e => {
            pond.removeFiles();
        });
    "
>
    <input type="file" x-ref="input">
</div>
