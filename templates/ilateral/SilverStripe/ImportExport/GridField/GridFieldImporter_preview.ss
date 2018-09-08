<% require css(i-lateral/silverstripe-importexport:client/dist/styles/main.css) %>

<div class="cms-content fill-height flexbox-area-grow cms-tabset center $BaseCSSClasses" data-layout-type="border" data-pjax-fragment="Content">
	<div class="toolbar toolbar--north cms-content-header vertical-align-items">
		<div class="cms-content-header-info flexbox-area-grow vertical-align-items">
			<h2><%t ImportExport.PreviewImport "Previewing import of {name}" name=$File.Name %></h2>
		</div>
	</div>

	<div class="cms-content-fields center ui-widget-content cms-panel-padded fill-height flexbox-area-grow" data-layout-type="border">
		<div class="cms-content-view">
			$MapperForm
		</div>
	</div>
</div>
