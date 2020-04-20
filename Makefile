SHELL := /bin/bash
tests:
	symfony run bin/phpunit tests/Controller/.
.PHONY: tests