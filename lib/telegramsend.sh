#!/bin/sh
#
#  This script sends whatever is piped to it as a message to the specified Telegram bot
#
message=$( cat )
apiToken=372103554:AAEV_0UNP0Dma6stIQLQ6NSXO4_yaLopvhw
# example:
# apiToken=123456789:AbCdEfgijk1LmPQRSTu234v5Wx-yZA67BCD
userChatId=356312104
# example:
# userChatId=123456789

sendTelegram() {
        curl -s \
        -X POST \
        https://api.telegram.org/bot$apiToken/sendMessage \
        -d text="$message" \
        -d chat_id=$userChatId
}

if  [[ -z "$message" ]]; then
        echo "Please pipe a message to me!"
else
        sendTelegram
fi
