from __future__ import absolute_import, division, print_function, unicode_literals

import optparse
import codecs
import os
import sys
import pycaption

if 2 == sys.version_info[0]:
    text = unicode
else:
    text = str


def main():
    parser = optparse.OptionParser("usage: %prog [options] file/directory")
    parser.add_option("-o", "--output",
                      action="store", # optional because action defaults to "store"
                      dest="output_filename",
                      default=None,
                      help="output file name",)

    (options, args) = parser.parse_args()

    if os.path.isdir(args[0]):
        directory = args[0]
        recursive_convert(directory)
    else:
        filename = args[0]
        convert_srt_file(filename, options.output_filename)


def recursive_convert(directory):
    pass


def convert_srt_file(input_filename, output_filename=None):
    try:
        captions = codecs.open(input_filename, encoding='utf-8', mode='r').read()
    except:
        captions = open(input_filename, 'r').read()
        captions = text(captions, errors='replace')

    content = read_captions(captions)
    if output_filename is None:
        if input_filename[-4:].lower() == '.srt':
            output_filename = input_filename[0: -4] + '.vtt'
        else:
            output_filename = input_filename + '.vtt'
    write_captions(content, output_filename)


def read_captions(captions):
    srt_reader = pycaption.SRTReader()
    if srt_reader.detect(captions):
        return srt_reader.read(captions)
    else:
        raise Exception('Illegal srt format :(')


def write_captions(content, output_filename):
    with open(output_filename, 'w') as output_file:
        output_file.write(pycaption.WebVTTWriter().write(content).encode("utf-8"))


if __name__ == '__main__':
    main()
