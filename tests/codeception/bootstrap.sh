#!/bin/bash

export WPDESK_PLUGIN_SLUG=wpdesk-export
export WPDESK_PLUGIN_TITLE="Wpdesk Export"

export WOOTESTS_IP=${WOOTESTS_IP:wootests}

sh ./vendor/wpdesk/wp-codeception/scripts/common_bootstrap.sh
