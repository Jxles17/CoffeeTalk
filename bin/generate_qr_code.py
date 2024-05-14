# pip install qrcode
# pip install "qrcode[pil]"

import qrcode

data = "https://vincentcomparato.fr"

filename = "tata.png"

img = qrcode.make(data)

img.save(filename)