# PDF Finder 🗞 🖇

This is a simple command line utility that allows you to look for PDF documents in any directory (recursively).

I have a lot of PDF documents spread around my home directory and subfolders and I'm too unorganized to do something
about it. Instead of taking an hour to organize the files, I took 7 hours to write this program. It uses `pdfinfo` to
collect metadata. The same can probably be achieved with simple shell scripts (globbing combined with `grep`, `sed`
and `awk`
gets you very very far). I chose PHP because I wanted to do something more with this (JSON API for my home network).
That part is left as an exercise for the reader.

There's two executables in `bin`: `pdf-finder.php` and `pdf-show-info.php`.

## Runtime requirements

To run it, you need [Composer](https://getcomposer.org/) and [PHP >= 7.4](https://www.php.net/), as well
as [poppler-utils](https://pypi.org/project/poppler-utils/). Installation of poppler-utils on Ubuntu is very simple:

```sh
sudo apt update && sudo apt install poppler-utils
```

The scripts are marked as executable so you can easily add them to your PATH. In my case, `~/.local/bin` is in my PATH, so I did the following:

```sh
ln -s /path/to/repository/bin/pdf-finder.php ~/.local/bin/pdf-finder
ln -s /path/to/repository/bin/pdf-show-info.php ~/.local/bin/pdf-show-info
```

Now you can just invoke them with `pdf-finder` and `pdf-show-info` respectively.

## Finding documents: `bin/pdf-finder.php`

The first executable, `pdf-finder.php`, is used to actually find PDFs based on search terms. The first argument should
always be the directory. Filters are optional.

### Examples

To find every PDF document with 'python' in its path, filename or any metadata field in the ~/Documents folder:

```sh
bin/pdf-finder.php ~/Documents python
```

... with 'python' in the title (metadata property):

```sh
bin/pdf-finder.php ~/Documents title=python
```

... with 'ritchie' in the author field and where the title property is set:

```sh
bin/pdf-finder.php ~/Documents author=ritchie title=
```

... with 'programming' and 'python' in the filename:

```sh
bin/pdf-finder.php ~/Documents filename=programming filename=python
```

### Available filters

Filters are based on the information supplied by the `pdfinfo`
command [(man page here)](https://www.xpdfreader.com/pdfinfo-man.html). Dates, when given, are printed in ISO-8601
format. Common fields are listed below. `filepath` (or `path`) is the path excluding the filename. `filename` (or `file`
or `name`) is the name of the file excluding the path.

| Common filters |
| :--- |
| `filepath`, `path` |
| `filename`, `file`, `name` |
| `title` | 
| `subject` | 
| `keywords` |
| `author` | 
| `creator` | 
| `producer` |

### A note on filters

About 50% of the PDF files on my computer contain usable metadata. It's almost never complete, although this depends on
the source you got your files from.

Using `path=python` yields the same results as `filepath=python`. The `path` is an alias to `filepath`. The same goes
for `file` and `name`: both are aliases to `filename`.

Filters are cumulative: adding more filters further restricts the output.

## Listing document info: `bin/pdf-show-info.php`

The second utility is basically a fancy wrapper for `pdfinfo`. It takes one argument, the path to a PDF document, and
spits out a table with information about the document.

```sh
$ bin/pdf-show-info.php ~/path/to/document.pdf
```

## Final note

Do as you please, as that is the beauty of open source.
