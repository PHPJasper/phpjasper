#!/usr/bin/env python3
#
# Expose jasperstarter's Report logic to Python using jpy.
#
# See https://jpy.readthedocs.io/en/latest/index.html for details on how to
# install jpy.
#
import os
from typing import Dict

SCRIPT_DIR = os.path.abspath(os.path.dirname(__file__))
EXAMPLES_DIR = os.path.dirname(SCRIPT_DIR)
#
# Locate jasperstarter.jar when installed, or in a development tree.
#
LIBS = os.path.join(os.path.dirname(EXAMPLES_DIR), 'lib')
if not os.path.isdir(LIBS):
    LIBS = os.path.join(os.path.dirname(os.path.dirname(os.path.dirname(EXAMPLES_DIR))), 'target',
                        'jasperstarter-dev-bin', 'lib')
CLASSPATH = os.path.join(LIBS, 'jasperstarter.jar')
assert(os.path.exists(CLASSPATH)), 'Unable to find jasperstarter in {0}'.format(LIBS)
#
# Load the JVM. See the jpy docs for details.
#
import jpyutil
jpyutil.init_jvm(jvm_maxmem='512M', jvm_classpath=[CLASSPATH])
#
# Load the Java types needed.
#
import jpy
Arrays = jpy.get_type('java.util.Arrays')
File = jpy.get_type('java.io.File')
Report = jpy.get_type('de.cenote.jasperstarter.Report')
Config = jpy.get_type('de.cenote.jasperstarter.Config')
DsType = jpy.get_type('de.cenote.jasperstarter.types.DsType')
System = jpy.get_type('java.lang.System')
PrintStream = jpy.get_type('java.io.PrintStream')
ByteArrayInputStream = jpy.get_type('java.io.ByteArrayInputStream')
ByteArrayOutputStream = jpy.get_type('java.io.ByteArrayOutputStream')


def generate_pdf(report: str, query: str, data: str, parameters: Dict[str, str]) -> bytearray:
    """
    Generate PDF from a report file using JSON.

    :param report:          The name of the report .jrxml.
    :param query:           A JSON query, e.g. "contacts.person".
    :param data:            The data in the form of a JSONified dict.
    :param parameters:      Settings for the report in the form of a dictionary
                            where the values are the string representations (in
                            Java format, so Python's True is 'true').
    :return: a bytearray.
    """
    #
    # Create the JasperStarter configuration. See Config.java for details.
    #
    config = Config()
    config.setInput(report)
    config.setOutput('-')
    config.setDbType(DsType.json)
    config.setJsonQuery(query)
    config.setDataFile(File('-'))
    config.setOutputFormats(Arrays.asList([]))
    config.setParams(Arrays.asList([k + '=' + v for k, v in parameters.items()]))
    #
    # Run the report. See Report.java for details.
    #
    report = Report(config, File(config.getInput()))
    savedStdin = getattr(System, 'in')
    savedStdout = System.out
    tmpStdout = ByteArrayOutputStream()
    try:
        System.setIn(ByteArrayInputStream(jpy.array('byte', bytearray(data, 'utf-8'))))
        System.setOut(PrintStream(tmpStdout))
        report.fill()
        report.exportPdf()
    finally:
        System.out.flush()
        System.setIn(savedStdin)
        System.setOut(savedStdout)
    #
    # Emit PDF.
    #
    return bytearray(tmpStdout.toByteArray())


if __name__ == '__main__':
    import json
    data = json.load(open(os.path.join(EXAMPLES_DIR, 'contacts.json')))
    pdf = generate_pdf(os.path.join(EXAMPLES_DIR, 'reports', 'json.jrxml'), 'contacts.person', json.dumps(data))
    print('PDF size is {0}'.format(len(pdf)))
    # open('out.pdf', 'wb').write(pdf)
