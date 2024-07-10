from telegram import InputMediaPhoto
from telegram.ext import Updater, CommandHandler, MessageHandler, filters

# Replace 'TOKEN' with your Bot's API token
TOKEN='7064747208:AAGNwY04DS82cT7DPywv4b1wpYA-vBriaPA'
application = Application.builder().token(TOKEN).build()

asyc def send_sticker(update, context):
    chat_id = update.message.chat_id
    sticker_file_id = 'STICKER_FILE_ID'

    # Replace 'STICKER_FILE_ID' with the file_id of the sticker you want to send
    sticker = InputMediaPhoto(media=sticker_file_id)

    context.bot.send_media_group(chat_id=chat_id, media=[sticker])

application.add_handler(send_sticker)
application.run_polling()
