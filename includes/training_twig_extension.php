<?php
class Training_Twig_Extension extends \Twig\Extension\AbstractExtension {

	public function getFunctions() {
		return [
			new \Twig\TwigFunction('lipsum', function ($string) {
					return strtolower($string);
				}),
			new \Twig\TwigFunction('getUser', function () {
					if (isset($_SESSION["user_email"])) {
						return $_SESSION["user_email"];
					} else {

						return '';
					}
				}
			),
		];
	}
	public function getFilters() {
		return [
			new \Twig\TwigFilter('rot13_with_extenstion', 'str_rot13'),
		];
	}

}
?>