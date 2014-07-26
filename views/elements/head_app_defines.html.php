<script>
App = {
	assets: {
		base: "<?= $this->assets->base() ?>"
	},
	media: {
		base: "<?= $this->media->base() ?>"
	},
	api: {
		discover: "<?= $this->url(['library' => 'cms_core', 'action' => 'api_discover', 'admin' => true, 'controller' => 'App']) ?>"
	}
}
</script>