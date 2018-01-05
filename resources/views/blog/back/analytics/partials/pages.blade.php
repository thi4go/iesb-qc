<div class="widget-11-2 panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">Páginas</div>
    </div>
    <div class="auto-overflow widget-11-2-table">
        <table class="table table-condensed table-hover no-margin">
            <tbody>
                @forelse ($pagesData as $pageRow)
                <tr>
                    <td class="b-r b-dashed b-grey col-lg-9">
                        <span class="hint-text small">{{{ $pageRow['url'] }}}</span>
                    </td>
                    <td class="col-lg-3">
                        <span class="font-montserrat small">{{{ $pageRow['pageViews'] }}}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="2">
                        <span class="hint-text small">Nenhum registro encontrado</span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
