humhub.module('globusfiles', function (module, require, $) {

    var client = require('client');
    var modal = require('ui.modal');
    var additions = require('ui.additions');
    var Widget = require('ui.widget').Widget;
    var object = require('util').object;
    var string = require('util').string;
    var loader = require('ui.loader');
    var event = require('event');

    var FolderView = function (node, options) {
        Widget.call(this, node, options);
    };

    object.inherits(FolderView, Widget);

    FolderView.prototype.init = function () {
        this.$fileList = this.$.find('#fileList');
        this.fid = this.$.data('fid');

        this.initFileList();
        //this.initSort();
        this.initEvents();
        this.initContextMenu();
    };

    FolderView.prototype.initSort = function () {
        var $sortColumn = this.$fileList.find('[data-ui-order]');
        if($sortColumn.length) {
            this.sort = $sortColumn.data('ui-sort');
            this.order = $sortColumn.data('ui-order');
        }
    };

    FolderView.prototype.initEvents = function () {
        var that = this;
        event.on('humhub:file:created.globusfiles', function (evt, files) {
            if (!object.isArray(files)) {
                files = [files];
            }

            var data = {guids: []};
            files.forEach(function (file) {
                data.guids.push(file.guid);
            });

            that.loader();
            client.post(that.options.importUrl, {data: data}).then(function (response) {
                if (response.success) {
                    that.reloadFileList();
                } else if (response.error) {
                    module.log.error(response.error, true);
                }
            }).catch(function (e) {
                module.log.error(e, true);
            }).finally(function () {
                that.loader(false);
            });
        });

        event.on('humhub:file:modified.globusfiles', function (evt, files) {
            that.reloadFileList().then(function () {
                module.log.success('success.saved');
            });
        });

        this.$.on('change', '.multiselect', function () {
            that.checkButtons();
        }).on('change', '.allselect', function () {
            that.$fileList.find('.multiselect').each(function () {
                $(this).prop('checked', $('.allselect').prop('checked'));
            });
            that.checkButtons();
        }).on('click', '[data-ui-sort]', function() {
            var $this = $(this);
            that.sort = $this.data('ui-sort');
            that.order = $this.data('ui-order') === 'ASC' ? 'DESC' : 'ASC';
            that.reloadFileList();
        });

    };

    FolderView.prototype.initFileList = function () {
        additions.observe($('#fileList'));
    };

    FolderView.prototype.initContextMenu = function () {
        var that = this;
        $("#bs-table tr").contextMenu({
            getMenuSelector: function ($invokedOn, settings) {


                var fileItem = FileItem.instance($invokedOn.closest('tr'));
                var selector;

                switch (fileItem.options['globusfilesType']) {
                    case "folder-posted":
                        selector = '#contextMenuAllPostedFiles';
                        break;
                    case "folder":
                        selector = '#contextMenuFolder';
                        break;
                    case "image":
                        selector = '#contextMenuImage';
                        break;
                    default:
                        selector = '#contextMenuFile';
                        break;
                }

                var $contextMenu = $(selector);

                if(fileItem.options['globusfilesEditable']) {
                    $contextMenu.find('.editableOnly').show();
                } else {
                    $contextMenu.find('.editableOnly').hide();
                }

                return selector;
            },
            menuSelected: function ($invokedOn, selectedMenu, evt) {
                evt.preventDefault();
                var item = that.getItemByNode($invokedOn);

                if (!item) {
                    module.log.error('Could not determine item for given context node', $invokedOn);
                }

                var action = selectedMenu.data('action');

                switch (action) {
                    case 'delete':
                        that.deleteItem(item);
                        break;
                    case 'edit-folder':
                        item.edit();
                        break;
                    case 'edit-file':
                        item.edit();
                        break;
                    case 'download':
                        item.transfer();
                        break;
                    case 'show-post':
                        document.location.href = item.wallUrl;
                        break;
                    case 'show-url':
                        that.showUrl(item);
                        break;
                    case 'move-files':
                        item.move(item);
                        break;
                    case 'zip':
                        that.downloadZip(item);
                        break;
                    default:
                        module.log.warn("Unkown action " + action);
                        break;
                }
            }
        });
    };

    FolderView.prototype.showUrl = function (item) {
        var options = module.config.showUrlModal;
        options.url = item.options.globusfilesUrlFull;

        options.head = item.options.globusfilesType === 'folder' ? options.headFolder : options.headFile;

        modal.global.set({
            header: options.head,
            body: string.template(module.templates.showUrlModalBody, options),
            footer: string.template(module.templates.showUrlModalFooter, options),
            size: 'normal'
        });

        modal.global.show();
    };

    module.templates = {
        showUrlModalBody: '<div class="clearfix"><textarea rows="3" class="form-control file-url-input" spellcheck="false" readonly>{url}</textarea><p class="help-block pull-right"><a href="#" data-action-click="copyToClipboard" data-action-target=".file-url-input"><i class="fa fa-clipboard" aria-hidden="true"></i> {info}</a></p></div>',
        showUrlModalFooter: '<a href="#" data-modal-close class="btn btn-default">{buttonClose}</a>'
    };

    FolderView.prototype.downloadZip = function (item) {
        var that = this;
        var $form = $('#globusfiles-form');
        $input = item.$.find('.item-selection').find('input');
        $oldVal = $input.prop('checked');
        $input.prop('checked', true);
        $form.attr("action", that.options.downloadArchiveUrl);
        $form.attr("method", "post");
        $form.submit();
        $input.prop('checked', $oldVal);
    };

    FolderView.prototype.deleteItem = function (item) {
        var that = this;
        this.confirmDelete(1).then(function (confirmed) {
            if (confirmed) {
                item.loader();
                client.post({
                    url: that.options.deleteUrl,
                    dataType: 'html',
                    data: {
                        'selection[]': item.id
                    }
                }).then(function (response) {
                    that.replaceFileList(response.html);
                }).catch(function (e) {
                    module.log.error(e, true);
                }).finally(function () {
                    item.loader(false);
                });

            }
        });
    };

    FolderView.prototype.replaceFileList = function (html) {
        this.$fileList.html(html);
        this.checkButtons();
        this.initContextMenu();
    };

    FolderView.prototype.confirmDelete = function (count) {
        var confirmOptions = {
            'body': string.template(module.text('confirm.delete'), {'number': count}),
            'header': module.text('confirm.delete.header'),
            'confirmText': module.text('confirm.delete.confirmText')
        };

        return modal.confirm(confirmOptions);
    };

    FolderView.prototype.checkButtons = function () {
        // Update selection menu and selection related buttons
        var checkCounter = this.getSelectionCount();
        if (checkCounter) {
            this.$.find('.selectedOnly').show();
            this.$.find('.chkCnt').html(checkCounter);
        } else {
            this.$.find('.selectedOnly').hide();
        }

        // Hide some nodes in case there are no items.
        if (!this.hasItems()) {
            this.$.find('.hasItems').removeClass('visible').addClass('hidden');
        } else {
            this.$.find('.hasItems').removeClass('hidden').addClass('visible');
        }

        if (!$('#folder-dropdown').children('.visible').length) {
            $('#directory-toggle').hide();
        } else {
            $('#directory-toggle').show();
        }
    };

    FolderView.prototype.deleteSelection = function (evt) {
        var that = this;
        this.confirmDelete(that.getSelectionCount()).then(function (confirmed) {
            if (confirmed) {
                that.loader();
                // submit selected item id's to action-url
                client.submit(evt, {'dataType': 'html'}).then(function (response) {
                    that.replaceFileList(response.html);
                    module.log.success('saved');
                }).catch(function (e) {
                    module.log.error(e, true);
                }).finally(function () {
                    that.loader(false);
                });
            }
        });
    };

    FolderView.prototype.changeSelectionVisibility = function (evt) {
        var that = this;
        this.loader();
        client.submit(evt, {'dataType': 'html'}).then(function (response) {
            that.replaceFileList(response.html);
            module.log.success('saved');
        }).catch(function (e) {
            module.log.error(e, true);
        }).finally(function () {
            that.loader(false);
        });
    };

    FolderView.prototype.zipSelection = function (evt) {
        var $form = $('#globusfiles-form');
        $form.attr("action", evt.$trigger.data('action-url'));
        $form.attr("method", "post");
        $form.submit();
        evt.finish();
    };

    FolderView.prototype.reloadFileList = function () {
        var that = this;
        this.loader();

        var cfg = (this.sort) ? {data: {sort: this.sort, order: this.order}} :  undefined;

        return client.get(this.options.reloadFileListUrl, cfg).then(function (response) {
            that.replaceFileList(response.output);
        }).catch(function (e) {
            module.log.error(e, true);
        }).finally(function () {
            that.loader(false);
        });
    };

    FolderView.prototype.loader = function (show) {
        var $loader = this.$.find('#globusfiles-crumb');
        if (show === false) {
            loader.reset($loader);
            return;
        }

        loader.set($loader, {
            'size': '8px',
            'css': {
                'padding': '0px',
                width: '60px'
            },
            'wrapper': '<li></li>'
        });
    };

    FolderView.prototype.hasItems = function () {
        return this.$fileList.find('[data-globusfiles-item]').length > 0;
    };

    FolderView.prototype.getSelectionCount = function () {
        return this.$fileList.find('.multiselect:checked').length;
    };

    FolderView.prototype.getSelectedItems = function () {
        var that = this;
        var result = [];
        this.$fileList.find('.multiselect:checked').each(function () {
            var item = that.getItemByNode(this);
            if (item) {
                result.push(item);
            }
        });
    };

    /**
     * Set upload source
     * @param {Upload} uploadComponent
     * @returns {undefined}
     */
    FolderView.prototype.setSource = function (uploadComponent) {
        var that = this;
        this.source = uploadComponent;
        this.source.on('humhub:file:uploadEnd', function (evt, response) {
            that.replaceFileList(response.result.fileList);
            if (response.result.infomessages && response.result.infomessages.length) {
                that.statusInfo(response.result.infomessages);
            }
        });
    };

    FolderView.prototype.reload = function () {
        // TODO
    };

    FolderView.prototype.add = function (file) {
        //Nothing todo here
    };

    FolderView.prototype.getItemByNode = function (node) {
        var $node = (node instanceof $) ? node : $(node);
        var item = Widget.closest($node);
        if (item instanceof FileItem) {
            return item;
        }

        return;
    };

    var FileItem = function (node, options) {
        Widget.call(this, node, options);
    };

    object.inherits(FileItem, Widget);

    FileItem.prototype.init = function () {
        this.id = this.$.data('globusfiles-item');
        this.type = this.$.data('globusfiles-type');
        this.url = this.$.data('globusfiles-url');
        this.wallUrl = this.$.data('globusfiles-wall-url');
        this.editUrl = this.$.data('globusfiles-edit-url');
        this.moveUrl = this.$.data('globusfiles-move-url');
    };

    FileItem.prototype.loader = function (show) {
        var $loader = this.$.find('.title');
        if (show === false) {
            loader.reset($loader);
            return;
        }

        loader.set($loader, {
            'size': '8px',
            'css': {
                'padding': '0px',
                width: '60px'
            }
        });
    };

    FileItem.prototype.edit = function () {
        debugger;
        modal.global.load(this.editUrl);
    };

    FileItem.prototype.transfer = function (){
        console.log(this.moveUrl);
        debugger;
        modal.global.load(this.moveUrl);
    }

    FileItem.prototype.move = function (item) {
        var that = this;
        var fid = $('#globusfiles-folderView').data('fid') || 0;
        modal.global.post({
            'url': item.moveUrl,
            'data': {
                'selection[]': item.id
            },
            'dataType': 'html'
        }).then(function () {
            _getDirectoryList().select(fid);
        }).catch(function (e) {
            module.log.error(e, true);
        });
    };

    var _getDirectoryList = function () {
        return Widget.instance('#globusfiles-directory-list');
    };

    var move = function (evt) {
        client.submit(evt, {dataType: 'html'}).then(function (response) {
            modal.global.setDialog(response.html);
            var fid = $('#globusfiles-folderView').data('fid');
            _getDirectoryList().select(fid);
            modal.global.show();
        }).catch(function (e) {
            module.log.error(e, true);
        });
    };

    var DirectoryList = function (node, options) {
        Widget.call(this, node, options);
    };

    object.inherits(DirectoryList, Widget);

    DirectoryList.prototype.init = function () {
        $('.directory-list li:last-child').addClass('last-child');
        $('.directory-list ul ul').hide();

        // handle selecting folders
        $('.directory-list .selectable').click(function () {
            $('.directory-list .selectedFolder').removeClass('selectedFolder');
            $(this).addClass('selectedFolder');
            $('#input-hidden-selectedFolder').val($(this).data('id'));
        });

        // handle open close subfolders
        $('.directory-list li:has(ul)')
            .addClass('hassub').find('>span, >a').click(function () {
            var parentFolder = $(this).parent();

            if (parentFolder.hasClass('expand')) {
                parentFolder.removeClass('expand').find('>ul').slideUp(
                    '200');
            } else {
                parentFolder.addClass('expand').find('>ul')
                    .slideDown('200');
            }
        });
    };

    DirectoryList.prototype.select = function (id) {
        this.openDirectory(id);
        this.selectDirectory(id);
    };

    DirectoryList.prototype.openDirectory = function ($id) {
        // optinal $id, set to 0 if undefined
        $id = $id || 0;
        var folder = $('#' + $id).parent();
        do {
            folder.addClass('expand');
            folder.find('>ul').slideDown('100');
            folder = folder.parent().closest('li');
        } while (folder.hasClass('hassub'))
    };

    DirectoryList.prototype.selectDirectory = function ($id) {
        // optinal $id, set to 0 if undefined
        $id = $id || 0;
        var item = $('#' + $id);
        item.addClass('selectedFolder');
        $('#input-hidden-selectedFolder').val($id);
    };

    var unload = function () {
        event.off('humhub:file:created.globusfiles');
        event.off('humhub:file:modified.globusfiles');
    };

    module.export({
        unload: unload,
        move: move,
        FolderView: FolderView,
        FileItem: FileItem,
        DirectoryList: DirectoryList
    });
});
